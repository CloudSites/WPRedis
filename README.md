wordpress_redis                                                                 
===============                                                                 
                                                                                
Wordpress Redis Plugin                                                          
                                                                                
Based off of: [Jim Westergren][1]                                               
                                                                                
                                                                                
  [1]: http://www.jimwestergren.com/wordpress-with-redis-as-a-frontend-cache/   
                                                                                
While its just a wrapper with an installer and configurable page, the primary performance gains would be first, localhost > local server > at last remote server. 
                                                                                
Things you need to know:                                                        
                                                                                
 - Server Hostname (localhost by default)                                       
 - Server port  (default port, however you may set to non-standard)             
 - Server Auth (this is needed as is, however enter null for none*)             
 - Database Instance # (0 by default)                                           
                                                                                
Barebones at the moment but hopefully plan to get more in here. 

**This is still in a beta status, use at your own peril**
