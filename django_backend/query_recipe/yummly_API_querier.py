import urllib2
import json

def API_request(query):
    query = query.replace(' ', '+')
    base_url =  'http://api.yummly.com/v1/api/recipes?_app_id=6082fbf2&_app_key=f4346b48f9a52cac8385d1ba029074e7'
    query_url = base_url + '&q=' + query
    html_response = urllib2.urlopen(query_url).read()
    response = json.loads(html_response)
    #pretty_print(response)
    
    #These are the fields we have available
    #print response['matches'][0].keys()
    
    datamodel = []
    for match in response['matches'][:10]:
        recipe = {'title' : match['recipeName'], 'ingredients' : match['ingredients']}       
        datamodel.append(recipe)
    return datamodel
    
    
def pretty_print(json_object):
    print json.dumps(json_object, sort_keys=True, 
                     indent=4, separators=(',', ': '))