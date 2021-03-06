//todo: add checkbox to always recur on same day of the week ("every tues do this")
//todo: add archive button for each group of tasks
//todo: make full task description clickable and fire checkbox checked event (deferring this since accidentally
// touching a task when trying to scroll would mark it as done and remove it from the list on reload. might be better
// UX to just force the user to click on the checkbox)
//todo: group future tasks by date
//todo: ability to send text
//todo: thin out the controller and move functions into a separate module
//todo: add authentication for one user (me)
//todo: add authentication and support for multiple users
angular.module('todoApp', ["firebase"])
    //.value('fbUrl', 'https://shining-inferno-6516.firebaseio.com/')
    //.service('fbRef', function(fbUrl) {
    //    return new Firebase(fbUrl)
    //})
    .controller('TodoListController', function($scope, $firebaseObject) {
        var todoList = this;
        var fbConnectionString = 'https://shining-inferno-6516.firebaseio.com/';
        var myDataRef = new Firebase(fbConnectionString + 'tasks');

        var currentDate = new Date();
        var currentDateString = currentDate.getDate() + '' + currentDate.getMonth() + '' + currentDate.getFullYear();

        todoList.todos = [];
        todoList.todayTodos = [];
        todoList.anytimeTodos = [];
        todoList.overdueTodos = [];

        todoList.selectedTasks = [];

        //myDataRef.orderByChild("date").on("child_added", function(task) {
        myDataRef.orderByChild("done").equalTo(false).on("child_added", function(task) {
            //can we bind directly to the control from firebase
            // without this intermediate object? i think so

            //alert(task.val().date);
            var taskDate;
            var taskDateString = '';

            if (typeof task.val().date != 'undefined')
            {
                taskDate = new Date(task.val().date);
                taskDateString = taskDate.getDate() + '' + taskDate.getMonth() + '' + taskDate.getFullYear();
            }
            else
                taskDate = '[any]';


            var pushOntoTodoList = function(targetTodoList, task, taskDate) {
                targetTodoList.push({
                    key: task.key(),
                    text: task.val().description,
                    date: taskDate.toDateString(),
                    done: task.val().done
                });
            };

            if (taskDateString.length > 0) {
                if (currentDateString == taskDateString)
                    pushOntoTodoList(todoList.todayTodos, task, taskDate);
                else if (currentDate > taskDate)
                    pushOntoTodoList(todoList.overdueTodos, task, taskDate);
                else
                    pushOntoTodoList(todoList.todos, task, taskDate)
            }
            else
            {
                todoList.anytimeTodos.push({
                    key: task.key(),
                    text: task.val().description,
                    date: taskDate,
                    done: task.val().done
                });
            }

        });

        //add the line below into the html to see the data in scope
        //<div>This: {{ data | json }}</div>

        //without this, the data doesn't load until some event
        // causes it to load, such as typing in the bound
        // text box in the form in index.html
        $scope.data = $firebaseObject(myDataRef);

        todoList.addTodo = function() {
            if (todoList.todoText.length > 0) {
                var taskDateToAdd = todoList.date == null ? null : todoList.date.getTime();

                var isoDate = new Date(todoList.date.toISOString());

                //console.log(taskDateToAdd);
                //console.log(todoList.date.toISOString());

                myDataRef.push({description:todoList.todoText, date:taskDateToAdd, done:false});

                //thanks to binding between angular and firebase, we don't need to
                // explicitly add new items to the list. anything pushed to firebase
                // will automagically show up in our list
                //todoList.todos.push({text:todoList.todoText, done:false});

                todoList.todoText = '';
            }
        };

        todoList.selectTask = function(key, done) {
            //todoList.selectedTasks.push(key);
            var taskRef = new Firebase(fbConnectionString + 'tasks/' + key);
            taskRef.child('done').set(done);
        };

        todoList.remaining = function() {
            var count = 0;
            angular.forEach(todoList.todos, function(todo) {
                count += todo.done ? 0 : 1;
            });
            return count;
        };

        todoList.archive = function(todoListToArchive) {
            console.log(todoListToArchive);
            //alert(args);

            //var oldTodos = todoListToArchive;
            //todoListToArchive = [];
            //angular.forEach(oldTodos, function(todo) {
            //    alert(todo.text);
            //    if (!todo.done) todoListToArchive.push(todo);
            //});
        };
    });
