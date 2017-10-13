# usrs
Simple php for user interaction and stuff

## SQL for the database I used

    CREATE TABLE `users` (
      `id` int(11) NOT NULL,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `meta` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    ALTER TABLE `users`
      ADD PRIMARY KEY (`id`),
      ADD UNIQUE KEY `username` (`username`);

# Functions

Dump data from all users

    dumpAllUserData();
    
Dump data for a given user   

    dumpUserData(1);
Create a new user     

    createUser(['username'=>'newUser','password'=>s('newPassword')]);
Update a users Password

    updateUserPassword(['id'=>1,'password'=>s('brandNewPassword')]);
    
Update a users metadata

    updateUserMeta(['id'=>1,'meta'=>'{"newMeta":"gotta love meta"}']);
    
Try auth with the user 

    auth(['username'=>'newUser','password'=>s('brandNewPassword')]);
    
Get a users meta    

    getUserMeta(1);
    
Delete a user    

    deleteUser(1);
    
Same as sha1()    

    s('sha1ThisPasswordPlx');
    
Make json look nice on echo    

    pretty('{"meta":"moreMeta"}');
