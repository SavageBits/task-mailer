var Firebase = require('firebase');
var myDataRef = new Firebase('https://shining-inferno-6516.firebaseio.com/tasks');

var currentDate = new Date();
var currentDateString = currentDate.getDay() + '' + currentDate.getMonth() + '' + currentDate.getFullYear();

var tasksToEmail = '';

//TODO: order by date
myDataRef.once('value', function(task) {
    task.forEach(function(data) {
        var taskDate = new Date(data.val().date);

        var taskDateString = taskDate.getDay() + '' + taskDate.getMonth() + '' + taskDate.getFullYear();

        if (currentDateString == taskDateString)
            tasksToEmail += data.val().description + '<br/>';
    });

    if (tasksToEmail.length > 0) {
        //console.log(tasksToEmail);
        var nodemailer = require('nodemailer');
        var generator = require('xoauth2').createXOAuth2Generator({
            user: 'savage.task.mailer@gmail.com',
            clientId: '617024214037-kenrfsrsiesuqvt5vgkpcq3e3l64144o.apps.googleusercontent.com',
            clientSecret: 'mhB8v-QG8HaXter0OSe2ncvu',
            refreshToken: '1/6JZzA-Zmx2H-oJYvSfQfESJnYwAdynj_WDUqhNv1-hc',
            accessToken: 'ya29.5wH63TKNv0-3hGHwnKr4fYVtqYwNWxq7WsAZhPt1yjFhsktfhjsGefoEtFDl7tv0pg7v' // optional
        });

        var transporter = nodemailer.createTransport({
            service: 'gmail',
            auth: {
                xoauth2: generator
            }
        });

        var mailOptions = {
            from: 'Task Mailer ✔ <savage.task.mailer@gmail.com>', // sender address
            to: 'mark@savagebits.com', // list of receivers
            subject: 'Do today!', // Subject line
            text: tasksToEmail, // plaintext body
            html: tasksToEmail // html body
        };

        transporter.sendMail(mailOptions, function (error, info) {
            if (error) {
                console.log(error);
            } else {
                console.log('Message sent: ' + info.response);
            }
        });
    }

    setTimeout(function() { process.exit(0); }, 15000);
});