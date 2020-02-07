#!/bin/bash

# Abraham Tishelman-Charny
# 5 February 2020
#
# The purpose of this script is to query HTCondor and store the output information in a text file.
# Run with watch -n <numSeconds> ./GetCondorInfo.sh
# where the script will run every <numSeconds> seconds 

user="atishelm" # set to lxplus username 

# Delete previous versions of files

file1="CondorOutput.txt"

if [ -f $file1 ] ; then
    rm $file1
fi

file2="CondorOutputElements.txt"

if [ -f $file2 ] ; then
    rm $file2
fi

file3="CondorElements.txt"

if [ -f $file3 ]; then
    rm $file3
fi 

echo "----------------"
echo "Querying Condor..."

condor_q >> CondorOutput.txt # save condor_q output 
sed -n -e '/OWNER/,// p' CondorOutput.txt >> CondorOutputElements.txt # save interesting lines only
lineNum=1

# Extract number of total jobs, jobs running, jobs idle, jobs finished
while IFS=" " read -r value1 value2 value3 value4 value5 value6 value7 value8 value9 remainder
do
   if [[ "$lineNum" -ne 1 ]]; then 
         
       #for value in $value6 $value7 $value8 $value9
       #do
           #if [[ "$value" == "_" ]]; then
	       #value="0"
           #fi
       #done
       if [[ "$value6" == "_" ]]; then 
	value6="0" 
       fi
       if [[ "$value7" == "_" ]]; then 
	value7="0" 
       fi
       if [[ "$value8" == "_" ]]; then 
	value8="0" 
       fi
       if [[ "$value9" == "_" ]]; then 
	value9="0" 
       fi

       if [[ "$value3" != *"query"* ]] && [[ "$value3" != *"all"* ]] && [[ "$value3" != *"$user"* ]] && [[ ! -z "$value3" ]]; then  
       	  #echo "$value3 $value6 $value7 $value8 $value9" | tr ' ' ,  >> CondorElements.txt
	  echo "$value3,$value6,$value7,$value8,$value9" >> CondorElements.txt
          
       fi
   fi

    let "lineNum+=1"
done < "CondorOutputElements.txt"

# Peaceful transfer of power
file4="CondorElements_tmp.txt"
if [ -f $file4 ]; then
    rm $file4 
fi 

if [ ! -f $file3 ]; then
    echo "No condor jobs running for user: $user"
else 
    cp CondorElements.txt CondorElements_tmp.txt
    rm CondorElements.txt 
fi 

echo "DONE"
