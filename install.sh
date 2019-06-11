#!/bin/sh
set -e

NAME='alexandria'
DATA_DIR="/var/$NAME"

PORT=7999
ADMIN_USERNAME='root'
ADMIN_PASSWORD=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | head -c 64)

mkdir -p $DATA_DIR
chmod 777 $DATA_DIR/data
mkdir $DATA_DIR/data

touch $DATA_DIR/config
chmod 400 $DATA_DIR/config
echo "ADMIN_USERNAME=$ADMIN_USERNAME" >> $DATA_DIR/config
echo "ADMIN_PASSWORD=$ADMIN_PASSWORD" >> $DATA_DIR/config

docker container run \
  --restart always \
  -d \
  --name $NAME \
  --env-file $DATA_DIR/config \
  -p $PORT:80 \
  -v $DATA_DIR/data:/data \
  -t whomenope/alexandria

echo; echo "Successfully deployed!"
echo "You can access Alexandria on:"
echo; echo "http://localhost:$PORT"; echo;
echo "Username: $ADMIN_USERNAME"
echo "Password: $ADMIN_PASSWORD"; echo
echo "You can change this by editing $DATA_DIR/config."
