# Real Pavlodar API Documentation

## Overview
This API provides endpoints to retrieve real estate properties with various filtering options.

## Endpoints

### Get All Properties
```
GET /api/v1/realties
```

Returns a paginated list of all properties with their associated images.

**Note:** Owner contact information (name and phone) is only visible to users with the 'realtor' role. For other users, these fields will be hidden.

### Get a Single Property
```
GET /api/v1/realties/{id}
```

Returns a single property with its associated images.

### Create a Property
```
POST /api/v1/realties
```

Creates a new property. This endpoint requires authentication.

### Update a Property (Moderation)
```
PUT /api/v1/realties/{id}
```

Updates an existing property. This endpoint requires authentication and is used for moderation purposes.

#### Request Body
```json
{
  "status": "sold",
  "price": 160000,
  "description": "Updated description with additional details"
}
```

All fields are optional during update. Only the fields that need to be changed should be included in the request.

#### Request Body for Create
```json
{
  "name": "Owner Name",
  "phone": "Owner Phone Number",
  "status": "active",
  "deal": "sale",
  "type": "apartment",
  "price": 150000,
  "address": "123 Main St",
  "rooms": 3,
  "description": "Beautiful apartment in the city center",
  "year_built": 2010,
  "height": 80,
  "balcony": "yes",
  "furniture": "yes",
  "parking": "yes",
  "floor": 5,
  "floors": 10,
  "is_first_floor": false,
  "is_last_floor": false,
  "is_new_building": false,
  "total_floors": 10,
  "coordinates": {"lat": 51.123, "lng": 71.456}
}
```

#### Required Fields
- name (string): Owner's name
- phone (string): Owner's phone number
- status (string): Property status (inactive, active, sold)
- deal (string): Deal type (rent, sale)
- type (string): Property type
- price (number): Property price
- address (string): Property address
- rooms (integer): Number of rooms

#### Optional Fields
- description (string): Property description
- year_built (integer): Year the property was built
- height (integer): Property area
- balcony (string): Balcony type
- furniture (string): Furniture type
- parking (string): Parking type
- floor (integer): Floor number
- floors (integer): Total floors in the building
- is_first_floor (boolean): Whether the property is on the first floor
- is_last_floor (boolean): Whether the property is on the last floor
- is_new_building (boolean): Whether the property is in a new building
- total_floors (integer): Total floors in the building
- coordinates (object): Property coordinates (latitude and longitude)

### Filtering Options
You can filter properties by adding query parameters to the URL:

#### Deal Type
```
GET /api/v1/realties?deal=rent
GET /api/v1/realties?deal=sale
```

#### Property Type
```
GET /api/v1/realties?type=apartment
GET /api/v1/realties?type=house
```

#### New Building
```
GET /api/v1/realties?is_new_building=true
```

#### Number of Rooms
```
GET /api/v1/realties?rooms=2
```

#### Price Range
```
GET /api/v1/realties?price_from=50000&price_to=100000
```

#### Area Range
```
GET /api/v1/realties?area_from=50&area_to=100
```

#### Floor Options
```
GET /api/v1/realties?not_first_floor=true
GET /api/v1/realties?not_last_floor=true
```

#### Amenities
```
GET /api/v1/realties?balcony=true
GET /api/v1/realties?parking=true
GET /api/v1/realties?furniture=true
```

#### Year Built Range
```
GET /api/v1/realties?year_from=2000&year_to=2023
```

#### With Photos
```
GET /api/v1/realties?with_photos=true
```

### Combining Filters
You can combine multiple filters:

```
GET /api/v1/realties?deal=sale&rooms=3&price_from=100000&price_to=200000&not_first_floor=true&balcony=true&with_photos=true
```

## Response Format
```json
{
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "John Doe",
        "phone": "+7 123 456 7890",
        "status": "active",
        "deal": "sale",
        "type": "apartment",
        "price": 150000,
        "address": "123 Main St",
        "rooms": 3,
        "description": "Beautiful apartment in the city center",
        "year_built": 2010,
        "height": 80,
        "balcony": "yes",
        "furniture": "yes",
        "flooring": "hardwood",
        "parking": "yes",
        "floor": 5,
        "floors": 10,
        "is_first_floor": false,
        "is_last_floor": false,
        "is_new_building": false,
        "total_floors": 10,
        "coordinates": {"lat": 51.123, "lng": 71.456},
        "created_at": "2023-06-16T07:40:27.000000Z",
        "updated_at": "2023-06-16T07:40:27.000000Z",
        "images": [
          {
            "id": 1,
            "realty_id": 1,
            "path": "storage/images/property1_1.jpg",
            "created_at": "2023-06-16T07:40:27.000000Z",
            "updated_at": "2023-06-16T07:40:27.000000Z"
          }
        ]
      }
    ],
    "first_page_url": "http://example.com/api/v1/realties?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://example.com/api/v1/realties?page=1",
    "links": [
      {"url": null, "label": "&laquo; Previous", "active": false},
      {"url": "http://example.com/api/v1/realties?page=1", "label": "1", "active": true},
      {"url": null, "label": "Next &raquo;", "active": false}
    ],
    "next_page_url": null,
    "path": "http://example.com/api/v1/realties",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
  },
  "message": "Realties retrieved successfully"
}
```
