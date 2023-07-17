REAL ESTATE API

1. INDEX
   1. All request goes into index.php then handle requests
   2. The endpoint should be /estates else respond with not found(404)
   3. Real estate gateway and request method sent to process request to
      handle the request
2. Auth
   1. Register
      1. POST: Register
      2. GET: Show Form
   2. Logout
      1. POST:Logout
   3. Login
      1. POST: Login
      2. GET: Show Form
3. Advertisement
   1. [GET]: show all ads
   2. [GET]/id: show specific estate with id
   3. [POST]: Create an Ad
   4. [DELET]/id: delete Ad
   5. [PUT]/id: update A
