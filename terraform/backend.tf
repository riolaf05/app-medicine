terraform {
  required_providers {
    aws = {
      source = "hashicorp/aws"
    }
  }

  backend "s3" {
    bucket  = "rioaws-terraform-state-dev"
    key     = "app-medicine/terraform.tfstate"
    region  = "us-east-1"
    profile = "default"
  }
}