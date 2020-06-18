

Hootsuite API [
====

## Requirement

1. [**HootSuite API**](#fngridlist) is require PHP 5.5+.
2. [**MySQL**](#fngridlist) You can use any mysql version.
that translates the generic items positions into responsive DOM elements with
drag and drop capabilities.

## HootSuite API

Jump to:

- [**Hootsuite Manage**](#api)
- [**Table Manage**](#primitives)
- [**Basic Usage**](#primitives)

### Hootsuite manage

#### new HootsuiteManager($token, $debugMode);

```php
include_once("autoload.php");

use HootSuite\HootsuiteManager;
use HootSuite\TableManager;

$token = "t8oiH10bqtnZk8kMIkRab3MceRiNOjKUO7RO6-Jf7kI.FhL21TiQSnCyMc_cmwZ-e4Z3K2eusRFKpFD3fzppyOg";
var myHootSuite= new HootsuiteManager(
    $token, 
    false
);
```

The **first**      parameter is an token of [hootsuite ](#primitives) to access.
The **second** parameter is debug mode.
You can set it as false


 - **return** - return the hootsuite handler.



#### postOne($draft_id)

```php
myHootSuite.postOne(1);//table id
```

Schedule a socials from the **mysql** database to **Hootsuite**:
socials: a message, a media

**draft_id** is the the id of mysql table.


 - **exception**
    1. when your message is already posted.
    2. when the draft id does not exist.
    3. when token expire or something.




#### postAll()

```php
myHootSuite.postAll();
```

Schedule all socials from the mysql to social sites



#### deletePost($draft_id)

```php
//delete the scheduled messages
myHootSuite.deletePost(1);//table id
```

Delete the scheduled social from the **hootsuite**



#### getSocials()

```php
//delete the scheduled messages
myHootSuite.getSocials();
```

Return all social from the **hootsuite**
For more detail, refer the response of the messages in  [Retrieve social profiles](https://platform.hootsuite.com/docs/api/index.html#operation/getSocialProfiles)



### Table Manage

#### addMedia($scheduledSendTime, $socialid, $title, $description, $media_fileName, $mime_type='video/mp4')


```php
myTbl.addMedia("2020-02-29 16:25:33", '129962363', "test 2", "This is test 2", "D:/bg.jpg", 'image/jpg');
```

The **scheduledSendTime**   parameter is the time to schedule the social sites
The **socialid** parameter is  a social id registered in hootsuite. Use the **getSocials()** to get the social ids
The **title** parameter is social title.
The **description** parameter is social content.
The **media_fileName** parameter is media path and name. should set the full path and name.
The **mime_type** parameter is mime. Valid mime is "video/mp4", "image/gif", "image/jpeg", "image/jpg", "image/png".



 - **return** - if the data is added successfully return the true otherwise return the error.

#### deleteMedia($draft_id)


```php
myTbl.deleteMedia(1);

```
 Delete only the draft from the mysql. Should avoid the scheduled message.

The **draft_id**   parameter is the table id.


 - **return** - if the data is added successfully return the true otherwise return the error.


### The data table structure

Refer  db_for_test.sql. It is backup file of the **Sqlyog**.

| Field| Type| Comment| 
| :--: | :--: | :--: | 
| id    | int(11) NOT NULL    |      | 
| socialid    | int(10) unsigned NOT NULL    | social site id in hootsuite    | 
| title|  varchar(200) NOT NULL    |  social title   | 
| description|  varchar(200) NOT NULL    |  social description   | 
| media_path|  varchar(200) NOT NULL    |  media path and name   | 
| mime_type|  varchar(200) NOT NULL    |  mime   | 
| posted_id|  varchar(200) NOT NULL    |   message id after posted  | 
| tags|  varchar(200) NOT NULL    |  tags for research. you can only use after purchased   | 
| scheduled_time|  datetime NOT NULL    |  schedule time   | 
| state|  varchar(200) NOT NULL    |  message state   | 
| created_at|  datetime NOT NULL    |     | 
| deleted_at|  datetime NOT NULL    |     | 

## Basic Usage

### Configuration
Find the file **path/HootSuite/Config.php**.
```php
$hootsuite_config = [
    'database'=>[
            'host' => 'localhost',
            'username' => 'root', 
            'password' => '',
            'port' => '3306',
            'db_name' => 'test_db',                 // database name
            'hootsuite_tbl' => 'media_draft_table', //hootsuite table
    ],
    'hootsuite'=>[
            'client_id'     =>  'xxxxxxxf-xxxx5-419a-bd8a-abb6823xxxxx',
            'secret_key'    =>  'ephgxxxxxxx',
            //hootsuite path in the project.
            //I did set it as follow.
            'hootsuite_root'=> 'https://hootsuite-testing-mysite.herokuapp.com/HootSuite/',
        //purchased state.
        //You can use tags(for search in social) after purchased hootsuite api.
            'is_purchased' => false, 
    ]
]
```
***Before using the hootsuite api, you must set the redirect_uri by contacting the hootsuite platform team*** (mailto:dev.support@hootsuite.com).
You can set the redirect_uri as follow.
```php
<YOUR_HOOTSUITE_ROOT>/callback.php
```
the **YOUR_HOOTSUITE_ROOT** is url that configured in Config.php
In above, YOUR_HOOTSUITE_ROOT=https://hootsuite-testing-mysite.herokuapp.com/HootSuite 
and can set https://hootsuite-testing-mysite.herokuapp.com/HootSuite/callback.php

### Example
```php
$myHootsuite = new HootsuiteManager();
$myHootsuite ->getSocials();
```
It will return like this....

```json
{
    [
        {
            "id": "115185509", //social id
            "type": "FACEBOOK",//social name
            "socialNetworkId": "1261768027866378",
            "socialNetworkUsername": "Pammy The Dog",
            "avatarUrl": "
        }
    ]
}
```
**1. Once runing above code,  it'll require the authentication.**
**2. Type your account and password and click the "Allow" button.**
**3. Then you got the token of the hootsuite in your site.(hootsuite_root/Utils/token.ini)**
**4. If the token is expired after one's time, it'll refresh the token automatically**

Then input the data in the **MySQL** like this
```php
$tblMng = new TableManager();
$tblMng->addMedia(
    "2020-02-29 16:25:33", //schedule date and time
    '115185509',           //social id
    "test 2",              //title
    "This is test 2",      //description
    "D:/bg.jpg",           //media path and name
    'image/jpg'            //mime
);

// after add the sql, this function return the added draft_id(really id in table). 
```

And to post this message as following this.
```php
// if returned the id 2 by addMedia
$myHootSuite->postOne(2);
```

You can also post all of the message from the **MySQL** table like this.
```php
// if returned the id 2 by addMedia
$myHootSuite->postAll();
```
To delete the posted message
```php
// if returned the id 2 by addMedia
$myHootSuite->deletePost(2);//$draft_id(table id)
```