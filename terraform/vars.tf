variable "project_info" {
  type        = string
  default     = "POC"
  description = "The project name"
}

variable "project_env" {
  type        = string
  default     = "dev"
  description = "The project env"
}

variable "project_prefix" {
  type        = string
  default     = "app-medicine"
  description = "The project name"
}


variable "project_name" {
  type        = string
  default     = "app-medicine"
  description = "The project name"
}

variable "project_dir" {
  type        = string
  default     = "app-medicine"
  description = "The name of the layer"
}

variable "region" {
  type        = string
  description = "The aws region"
}

variable "profile" {
  type        = string
  default     = "default"
  description = "The aws cli profile"
}

variable "enable_bastion" {
  type        = bool
  description = "True to enable bastion host"
  default     = false
}

variable "enable_rds" {
  type        = bool
  description = "True to enable RDS db"
  default     = false
}
