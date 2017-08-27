FROM ubuntu-debootstrap

WORKDIR /app

ADD . /app

RUN apt-get update && apt-get -y upgrade 
RUN apt-get install -y apache php7.0 

EXPOSE 80