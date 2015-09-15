//todo: add checkbox to always recur on same day of the week ("every tues do this")

angular.module('todoApp', ["firebase"])
    .controller('TodoListController', function($scope, $firebaseObject) {
        var todoList = this;
        var fbConnectionString = 'https://shining-inferno-6516.firebaseio.com/';
        var myDataRef = new Firebase(fbConnectionString + 'tasks');

        todoList.todos = [];
        todoList.selectedTasks = [];

        //myDataRef.orderByChild("done").equalTo(false).orderByChild("date").on("child_added", function(task) {
        myDataRef.orderByChild("done").equalTo(false).on("child_added", function(task) {
            //can we bind directly to the control from firebase
            // without this intermediate object? i think so

            //alert(task.key());

            var taskDate = new Date(task.val().date)

            todoList.todos.push({
                key: task.key(),
                text: task.val().description,
                date: taskDate.toDateString(),
                done: task.val().done
            });
        });

        //add the line below into the html to see the data in scope
        //<div>This: {{ data | json }}</div>

        //without this, the data doesn't load until some event
        // causes it to load, such as typing in the bound
        // text box in the form in index.html
        $scope.data = $firebaseObject(myDataRef);

        todoList.addTodo = function() {
            myDataRef.push({description:todoList.todoText, date:todoList.date.getTime(), done:false});

            //thanks to binding between angular and firebase, we don't need to
            // explicitly add new items to the list. anything pushed to firebase
            // will automagically show up in our list
            //todoList.todos.push({text:todoList.todoText, done:false});

            todoList.todoText = '';
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

        todoList.archive = function() {
            var oldTodos = todoList.todos;
            todoList.todos = [];
            angular.forEach(oldTodos, function(todo) {
                if (!todo.done) todoList.todos.push(todo);
            });
        };
    });
