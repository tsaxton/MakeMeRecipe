from django.conf.urls import patterns, url

from search import views

urlpatterns = patterns('',
    url(r'^$', views.index, name='index'),
    url(r'^searchResults$', views.query_recipe_API, name='query_recipe_API'),
)
