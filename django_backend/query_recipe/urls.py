from django.conf.urls import patterns, url

from query_recipe import views

urlpatterns = patterns('',
    url(r'^$', views.index, name='index'),
    url(r'^(?P<API_query>\S+)/$', views.query_recipe, name='query_recipe'),
)