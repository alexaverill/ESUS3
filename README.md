# ESUS3
Current version of the Event Sign Up System


#Install instruction
Install instructions:
This will walk you through installing a standard two division setup for ESUS, if you only need one division just install ESUS into the base
directory. 

First download ESUS from: https://github.com/alexaverill/ESUS3/archive/master.zip
Requirements: 
Php5
mysql


Next setup a database for each install of ESUS, for two division setup two different databases.
The naming convention tends to work best as esus_competition_b and esus_competition_c

Once you have your databases setup upload and unpack the zip file from step one. You should unpack the files into the following structure for 
two divisions:

[url]/[Competition]/b/[ESUS Files]
and 
[url]/[Competition]/c/[ESUS Files]

Next navigate to install.php in each directory that you unpacked files into and enter the information to each box in the install dialog.

Once you have added a new administrator account delete install.php and new_admin.php from each directory.
