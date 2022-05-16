<?php
/**
 * Created by PhpStorm.
 * User: anuj
 * Date: 24/10/18
 * Time: 11:07 AM
 */

namespace TBETool;

use Exception;

/**
 * Generate screenshots from the video file using the FFMPEG library
 *
 * Class GenerateVideoScreenshots
 * @package App\Library\AnujTools
 */
class GenerateVideoScreenshots
{
    private $ffmpeg;
    private $extension = 'jpg';
    private $video_file;
    private $output_path;

    /**
     * PapVideoScreenshots constructor.
     * @param $ffmpeg_path
     */
    public function __construct($ffmpeg_path)
    {
        $this->ffmpeg = $ffmpeg_path;
    }

    /**
     * Set output path
     *
     * @param $output_path
     */
    public function setOutputPath($output_path)
    {
        $this->output_path = $output_path;
    }

    /**
     * Generate screenshots by providing the video absolute path
     *
     * @param $video_file : Absolute path of the video
     * @param $output_path
     * @return bool
     * @throws Exception
     */
    public function generateScreenshot($video_file, $output_path = '')
    {
        if (empty($video_file)) {
            throw new Exception('Please provide video file absolute path');
        }

        if (!is_file($video_file)) {
            throw new Exception('Given path is not a valid file path');
        }


        $this->video_file = $video_file;
        $this->_setOutputPath($output_path);

        $screenshot_name = $this->_getFileName();

        $screenshot_path = $this->output_path . '/' . $screenshot_name;

        $command = $this->ffmpeg .' -i '.$video_file.' -ss 00:00:01 -vframes 1 ' . $screenshot_path . ' 2>&1';

        $output = shell_exec($command);

        if (is_file($screenshot_path)) {
            return $screenshot_path;
        } else {
            throw new Exception('Error generating screenshot: ' . $output);
        }
    }

    /**
     * Generate file name
     * @return string
     */
    private function _getFileName()
    {
        $file_name = time() . '-' . str_shuffle(time()) . '.' . $this->extension;

        return $file_name;
    }

    /**
     * Set output path
     * @param $output_path
     */
    private function _setOutputPath($output_path)
    {
        if (empty($output_path) && empty($this->output_path)) {
            $video_path_explode = explode('/', $this->video_file);
            $path = str_replace(end($video_path_explode), '', $this->video_file);
        } elseif (!empty($output_path)) {
            $path = $output_path;
        } else {
            $path = $this->output_path;
        }

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $path = rtrim($path, '/');

        $this->output_path = $path;
    }
}
