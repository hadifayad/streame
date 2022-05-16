# php-video-screenshot
Generate screenshot from the video file using PHP

---
### Requirement
* FFMPEG

### Using the Library

#### Installation

Intall library in PHP project using composer
```
composer require tbetool/php-video-screenshot
```

#### Using Library
```
$obj = new GenerateVideoScreenshots(FFMPEG_PATH);
$obj->setOutputPath('output_location');
```

#### Generating screenshot/thumbnail
Screenshot/Thumbnail can be generate by passing absolute path of the video file in following function call.
```
$thumbnail = $obj->generateScreenshot('video_file_path');
```
If you want to save screenshot to a different directory, you can pass the path of the directory as the second parameter.
```
$thumbnail = $obj->generateScreenshot('video_file_path', 'output_path');
```

---
#### NOTE
* If output path is not set using **setOutputPath()** or during **generateScreenshot()**, it will use the path to the video file to save the screenshot.

---

### Exception Handling
_Ex:_
```
try {
    $thumbnail = $obj->generateScreenshot('video_file_path');
} catch (Exception $exception) {
    echo $exception->getMessage();
}
```

---
### Bug Reporting

If you found any bug, create an [issue](https://github.com/TBETool/php-video-screenshot/issues/new).

---
### Support and Contribution

Something is missing? 
* `Fork` the repositroy
* Make your contribution
* make a `pull request`

    
