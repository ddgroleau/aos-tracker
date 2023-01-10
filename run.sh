#!/bin/bash

if [[ -z $(docker container ls -a | grep "aos_tracker") ]];
then echo "No container found. Starting aos_tracker container...";
else docker stop aos_tracker && docker rm aos_tracker;
fi;

docker build . -t aos_tracker
docker run -d -p 4000:80 --name aos_tracker aos_tracker