### Install

```console
cd terraform\module-lambda\lambdas

docker build -t app-integratore-lambda-container .

docker tag app-integratore-lambda-container:latest 135588427727.dkr.ecr.us-east-1.amazonaws.com/
app-integratore-lambda-container:v0.1.4

aws --region us-east-1 ecr get-login-password | docker login --username AWS --password-stdin 135588427727.dkr.ecr.us-east-1.amazonaws.com

docker push 135588427727.dkr.ecr.us-east-1.amazonaws.com/app-integratore-lambda-container:v0.1.4

cd ..\..

terraform apply

python main.py
```

ssh -i "C:\Users\lafacero\.ssh\id_rsa" ubuntu@ec2-3-250-180-1.eu-west-1.compute.amazonaws.com