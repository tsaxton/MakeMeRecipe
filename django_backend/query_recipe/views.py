# Create your views here.
from django.http import Http404
from django.http import HttpResponse
from django.shortcuts import render
import query_yummly

def index(request):
    return render(request, 'query_recipe/search.html',{})

def query_recipe(request, API_query):
    query_response = query_yummly.API_request(API_query);
    return render(request, 'query_recipe/recipe_list.html', {'query_response': query_response})
