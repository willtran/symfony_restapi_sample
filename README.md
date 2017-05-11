# Symfony REST API SAMPLE

## Development Environment

We've chosen to use Docker to host the development environment for this project.
Docker provides a lighweight "container" system which we expect will result in 
simpler, faster development environment builds and a faster development cycle.  

### Getting Started

1. Ensure Docker is installed on your machine.  Follow the instructions below to
install docker and Docker Compose on your workstation.

1. From the project root run `docker-compose up -d --build` to build the Docker images 
   and start them running on your machine.

1. Run `docker ps` to confirm that the docker containers are running.  Note: It's expected 
   that the websockets container will be stuck in a "restarting" state until the composer 
   install and other steps are run later.

1. Run `sh local-utils/create-docker-sample-db.sh`

1. Restore a starter database to MySQL:

       mysql -h 127.0.0.1 -P 3307 -u app -p'Gadu1sag82AD' -D app < local-utils/sample.sql

1. Create the parameters.yml symlink:

       cd article_crud/app/config
       ln -s parameters.yml.docker parameters.yml
       cd ../../..

1. Do a `composer install` to install all of the required dependencies:

       sh local-utils/docker-composer.sh install

1. Ensure Symfony can write to the locations it needs to write to (for dev environment only):

       chmod 777 article_crud/var/
      
1. You should now be good to go!  Hit up <http://localhost:8000/> in your browser.

### Useful Commands

***Start all containers for this project***

    docker-compose up -d
    
***Stop all containers***

    docker-compose stop

***Destroy all containers***

    docker-compose down

***See a list of running containers***

    docker ps

## Installing Docker

### Docker


Please ensure Docker is installed on your development workstation before you 
continue.  To install it, follow the [Install Docket on CentOS](https://docs.docker.com/engine/installation/linux/centos/) 
instructions on the Docker website.  Follow through all of the steps in the "Install 
Docker Engine" (use the "Install with yum" process, not "Install with the 
script"), "Create a Docker Group", and "Start the docker daemon at boot" 
sections.

Once this has completed successfully you should be able to run the following command as your regulsr user:

    docker run --rm hello-world

And see output similar to the following:

    Hello from Docker!
    This message shows that your installation appears to be working correctly.
    
    To generate this message, Docker took the following steps:
     1. The Docker client contacted the Docker daemon.
     2. The Docker daemon pulled the "hello-world" image from the Docker Hub.
     3. The Docker daemon created a new container from that image which runs the
        executable that produces the output you are currently reading.
     4. The Docker daemon streamed that output to the Docker client, which sent it
        to your terminal.
    
    To try something more ambitious, you can run an Ubuntu container with:
     $ docker run -it ubuntu bash
    
    Share images, automate workflows, and more with a free Docker Hub account:
     https://hub.docker.com
    
    For more examples and ideas, visit:
     https://docs.docker.com/engine/userguide/

### Docker Compose

We're using Docker Compose to make managing multi-container environments easier.  You'll need to install it using the following commands:

    sudo su -
    curl -L https://github.com/docker/compose/releases/download/1.9.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
    exit

Once installed you can run `docker-compose -v` and you should see output as follows:

    $ docker-compose -v
    docker-compose version 1.9.0-rc4, build 181a4e9

