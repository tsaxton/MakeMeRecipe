# Create your views here.
from django.http import Http404
from django.http import HttpResponse
from django.shortcuts import render
import yummly_API_querier

def index(request):
    return render(request, 'search/search.html',{})

def query_recipe_API(request):
    #Query recipe is called with data from the search form
    #We access this data:
    API_query = request.GET['ingredients']
    
    query_response = yummly_API_querier.API_request(API_query);
    return render(request, 'search/search_results.html', {'query_response': query_response})
