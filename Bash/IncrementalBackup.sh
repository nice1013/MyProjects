#!/bin/bash
#Created by Ed Evanosich December 6th 2016.
#This script will make a backup using the current date as an extension.
#We use Rclone to backup to the most popular storage places. 
#52[54 according to date's week's docs] weeks, 
#plus 48 for hours in 2 days. Equals 100 backups. 


#The first part of our Backup Name 
partName="Backup"
#We make backups hourly. For how many days, is based on this var.
amountofdays=2


#We need the current day and the current hour so we can make our extension
#to our new backup file. 
#Day of month 1-31
curday=$(date +"%d")
#Hour of day 0-23
curhour=$(date +"%H")
#Day of the week. 1-7
dayweek=$(date +"%u")
#Week of the year. 
weekyear=$(date +"%W")

#Now our day could be any day in the month. But we only want what our 
#amountofdays var says. So we simply use that number to get a remainder. 
#For example if our day is 3. The only possible answers is 0, 1, 2.
curRemainder=$(($curday % $amountofdays))


#Check to see if this is our weekly backup as that has a different format.
if [ $dayweek = 1 ] && [ $curhour = 0 ]; then
    #Weekly format
    extension=$weekyear"_"$curRemainder"_"$curhour
else
    #Regular format
    extension=$curRemainder"_"$curhour
fi


#Backup file name with extension. 
filename=$partName"_"$extension"/"




#Now we use Rclone to make the backups to our sites.
#Dropbox
rclone sync ~/Desktop/TestDropBox "Ed Dropbox":$filename
#Google Drive
#rclone sync ~/Desktop/TestDropBox "Ed Dropbox":
#Amazon
#rclone sync ~/Desktop/TestDropBox "Ed Dropbox":




