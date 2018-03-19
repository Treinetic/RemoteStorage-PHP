# Treinetic Remote Storage - PHP SDK


# Installing



# Usage

### Initialization

Import StorageClient into your .php file

```php
use Treinetic\RStorage\StorageClient;
```

Then initialize the `StorageClient`. `StorageClient`'s constructor accept 3 arguments.
- `URL` endpoint of the remote server
- `accessKey` enpoint access key
- `secretKey` enpoint secret key


```php
$storageClient = new \Treinetic\RStorage\StorageClient($server,
                                                       $accessKey,
                                                       $secretKey);
```

### Make Directory
```php
$storageClient->makeDirectory("dirName");
```

### Store files
```php
$storageClient->put('./test/img.jpg', 'user/profile', 'my.jpg');
```
- 1st parameeter is the local file path
- 2nd parameter is the remote directory. (It will create a directory if not exists)
- 3rd prarameter is the file name for remote file

### Get Files
```php
$response = $storageClient->get('user/profile/my.jpg');
file_put_contents('img.jpg', $response);
```

### Copy Files
```php
$storageClient->copy('user/profile/my.jpg', 'user/profile/copy.jpg');
```
- 1st parameter is the source file
- 2nd parameter is the destination file

### Move Files
```php
$storageClient->move('user/profile/my.jpg', 'user/profile/move.jpg');
```
- 1st parameter is the source file
- 2nd parameter is the destination file

### Check if exists
```php
$result = $storageClient->exists('user/profile/my.jpg');
var_dump($result); // true or false
```

### Delete Files
```php
$storageClient->delete('user/profile/my.jpg');
```
