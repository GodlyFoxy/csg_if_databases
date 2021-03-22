FROM gitpod/workspace-mysql
                    
USER gitpod

RUN sudo mkdir /var/log/apache2 \

    && sudo chmod 755 /var/log/apache2

RUN sudo touch /var/log/apache2/access.log \

    && sudo chmod 666 /var/log/apache2/access.log

RUN sudo touch /var/log/apache2/error.log \

    && sudo chmod 666 /var/log/apache2/error.log

RUN sudo touch /var/log/apache2/other_vhosts_access.log \

    && sudo chmod 666 /var/log/apache2/other_vhosts_access.log



# Install custom tools, runtime, etc. using apt-get
# For example, the command below would install "bastet" - a command line tetris clone:
#
# RUN sudo apt-get -q update && #     sudo apt-get install -yq bastet && #     sudo rm -rf /var/lib/apt/lists/*
#
# More information: https://www.gitpod.io/docs/config-docker/
