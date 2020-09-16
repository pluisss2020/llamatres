FROM python:3.7.5
# set lang
ENV LANG C.UTF-8
# Set the working directory to /app
WORKDIR /app
# Copy files to working directory
COPY . /app
COPY zoomagri-test-data-dev /mnt/shared/zoomagri-test-data-dev
# Install!
RUN ./install.sh

# Run nosetests when the container launches without commands
CMD ["python", "setup.py", "nosetests"]
