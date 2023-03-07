module "ec2" {
    source        = "git::https://github.com/riolaf05/terraform-modules//aws/ec2"
    count         = var.enable_bastion ? 1 : 0
    project_info  = var.project_info
    profile       = var.profile
    region        = var.region
    project_env   = var.project_env
    ec2_name      = "app-medicine"
    instance_type = "t2.micro"
    sec_group     = "sg-05a68ad940e4848c9"
    subnet_id     = "subnet-0ecb37eccb85264be"
    public_key    = "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQCjI5skAVhhjOotpwsGlNjL2HUKqlidNDs1EkI99aBbKM5ZIXXWEDb9DutYZ0t2yr6kMzJGXO1Qsp+MkYGYr9uRM+SVSUM5jb6fgcjIINcb+MyTfUtn0ZxwizDyo90iggPg2EHH7BHsuf/G05Elxp1Kx3oZkUJEjvGU5K2G89pc91+i+dbSXpX3kuUFsRB6AZfMCVnGqAluUT6vAK3O++MyMIaPWQDXEsSD6nhMcfEmNtQCBtmUKgkHPxPmZuIhb6v1EURUpn/42xMa2RKRk+KkPpBKzCF+WrPTua7iED6WFlhmtNku2zyRbADLos16MRO4cy42cgW6Jx8G4fD4eQw8iepRNdqj9qaq1p3Rf1bazY06W5SINu5WHeYrTO3v+QB07jPk9A4Q5/DT0adDFwSj/iENmSZd3zBYaGZCa3oW5oE8eN0I+tRfoQL/IJm7tYtqXeM91HRKSLUjHr8eb4+lDXwRDcFDqlKh/MxnNCiz3A0gSYj1temNd0Uwv08TcxZaUd3kHN9i+PfSznMvfYiTZM732T2wtgS7yajmCFW4xe/4jPR13hPjj4KYkp2kHgfZnVyksU2ALAf39Pjz8KYdiElnZm3yIRnSFotKMMvCHmuwV5fRNZLw7Wqz9WmWcSASI0QUYEAj98cW5Gus4sbNvB9i372HZuih1CsmBUJzCQ== valueteam\\lafacero@vt-lafacero"
    user_data     = <<EOT
#!/bin/bash
sudo apt-get update \
&& sudo apt install -y docker.io git \
&& sudo curl -L 'https://github.com/docker/compose/releases/download/1.26.2/docker-compose-$(uname -s)-$(uname -m)' -o /usr/local/bin/docker-compose \
&& sudo chmod +x /usr/local/bin/docker-compose \
&& sudo systemctl enable docker 
    EOT
}
