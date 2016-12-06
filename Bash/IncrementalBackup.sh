#!/bin/bash
#Created by Ed Evanosich December 6th. 
#This script will do incremental backups to files within a certain folder. 
#We use Rclone to backup to the most popular storage places. 


#The first part of our Backup Name 
partName="Backup"
#We make backups hourly. For how many days, is based on this var.
amountofdays=3


#We need the current day and the current hour so we can make our extension
#to our new backup file. 
curday=$(date +"%d")
curhour=$(date +"%H")

#Now our day could be any day in the month. But we only want what our 
#amountofdays var says. So we simply use that number to get a remainder. 
curRemainder=$(($curday % $amountofdays))

#Now we concatenate our current remainder and our curHour and we have our 
#extension name for this current backup.
extension=$curRemainder"_"$curhour

#Backup file name with extension. 
filename=$partName"_"$extension

#Now we use Rclone to make the backups to our sites.
#Dropbox
rclone sync ~/Desktop/TestDropBox "Ed Dropbox": 
#Google Drive
rclone sync ~/Desktop/TestDropBox "Ed Dropbox":
#Amazon
rclone sync ~/Desktop/TestDropBox "Ed Dropbox":




