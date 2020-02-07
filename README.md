# Monidor 

Contact:
- Abraham Tishelman-Charny - abraham.tishelman.charny@cern.ch

The purpose of this respository is to supply to files necessary for creating an HTCondor jobs monitor (Monidor) to monitor the status of the user's jobs.  

# Setup

In order to create a monidor, you need a bash script to query HTCondor and a php file to display the results. To set this up, go to your CERN website location on lxplus, for example on EOS and clone this repository: 

	cd /eos/user/<userLetter>/<userName>/www/

Via HTTPS:

	git clone https://github.com/atishelmanch/Monidor.git

or via SSH:

	git clone git@github.com:atishelmanch/Monidor.git

The first thing that needs to be changed is the "user" variable in GetCondorInfo.sh, which should be set to your lxplus username, and the "userName" variable in index.php, which should be set to which ever name / nickname you would like to be part of the title of the graph.

To setup the monidor, you need to run the script GetCondorInfo.sh on a loop:

	watch -n 10 ./GetCondorInfo.sh

This will run GetCondorInfo.sh every 10 seconds, meaning every 10 seconds the output file CondorElements_tmp.txt will have been updated with the most up to date condor query info. As long as this is running in a terminal, and your CERN website is setup properly ([done here](https://webservices.web.cern.ch/webservices/), see [here](https://espace.cern.ch/webservices-help/websitemanagement/ManagingWebsitesAtCERN/Pages/WebsitecreationandmanagementatCERN.aspx)) you should be able to see your monitor at:

	http://<lxplusUser>.web.cern.ch/<lxplusUser>/<path_to_MonidorDirectory>/index.php

If everything is working properly, you should see the graph automatically refresh every 5 seconds and it should look something like this (as long as you have condor jobs running):

![alt text](https://github.com/atishelmanch/Monidor/blob/master/MonidorExample.png "Hey, look at that useful monidor!")
