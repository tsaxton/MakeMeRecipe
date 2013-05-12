from django.conf.urls import patterns, url

from query_recipe import views

urlpatterns = patterns('',
    url(r'^search$', views.index, name='index'),
    url(r'^searchResults$', views.query_recipe_API, name='query_recipe_API'),
)