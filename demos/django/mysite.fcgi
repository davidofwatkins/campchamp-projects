#!/home2/davidofw/python/bin/python
import sys, os

# Add a custom Python path.
sys.path.insert(0, "/home2/davidofw/python")
sys.path.insert(13, "/home2/davidofw/myproject")

os.environ['DJANGO_SETTINGS_MODULE'] = 'myproject.settings'
from django.core.servers.fastcgi import runfastcgi
runfastcgi(method="threaded", daemonize="false")
