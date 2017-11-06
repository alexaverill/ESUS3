# ESUS3
# Needed work
The entire project needs to be refactored. I have learned a lot since the last time this code has been touched and would need to rewrite most SQL queries and redesign the database in order to have a much cleaner and simplier project. The project currently works as is, but is not really a good representation of coding standards and mysql database design standards/ best practices. 


## This code is working, however it needs to be refactored. 
Current version of the Event Sign Up System. 



# Install Instructions
Install instructions:
This will walk you through installing a standard two division setup for ESUS, if you only need one division just install ESUS into the base
directory. 

First download ESUS from [here](https://github.com/alexaverill/ESUS3/archive/master.zip)

Requirements Server running PHP5 and Mysql.

Next setup a database in mysql for each install of ESUS, for two division setup two different databases.
The naming convention tends to work best as esus_competition_b and esus_competition_c

Once you have your databases setup upload and unpack the zip file from step one. You should unpack the files into the following structure for 
two divisions:
```
[url]/[Competition]/b/[ESUS Files]
and 
[url]/[Competition]/c/[ESUS Files]
```
Next navigate to install.php in each directory that you unpacked files into and enter the information to each box in the install dialog.

Once you have added a new administrator account delete install.php and new_admin.php from each directory.

