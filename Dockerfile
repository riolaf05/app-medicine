FROM ubuntu:20.04

RUN apt-get update && apt-get install -y python3-pip
RUN pip install --upgrade pip 
COPY requirements.txt .
RUN pip install -r ./requirements.txt
COPY main.py ./

CMD [ "main.handler" ]