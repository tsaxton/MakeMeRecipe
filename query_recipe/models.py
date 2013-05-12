from django.db import models

# Create your models here.
from django.db import models

class Recipe(models.Model):
    title = models.CharField(max_length=200)
    
    #Title and image are cached. Other nessesary information can be pulled from the link
    link = models.CharField(max_length=200)
    
    #This is the source of the data, which tells us how to parse it
    origin = models.CharField(max_length=200)
    