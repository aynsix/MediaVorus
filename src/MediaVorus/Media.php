<?php

/**
 * Copyright (c) 2012 Romain Neutron
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace MediaVorus;

use \Symfony\Component\HttpFoundation\File\File as SymfonyFile;

/**
 *
 * @author      Romain Neutron - imprec@gmail.com
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Media
{

  public static function guess(\SplFileInfo $file)
  {

    if (!$file instanceof SymfonyFile)
    {
      $file = new SymfonyFile($file->getPathname());
    }

    $mime = $file->getMimeType();

    switch ($mime)
    {
      case strpos($mime, 'image/') === 0:
      case 'application/postscript':
        return new Media\Image($file, new \PHPExiftool\Exiftool);
        break;

      case strpos($mime, 'video/') === 0:
      case 'application/vnd.rn-realmedia':
        return new Media\Video($file, new \PHPExiftool\Exiftool);
        break;

      case strpos($mime, 'audio/') === 0:
        break;

      case 'text/plain':
      case 'application/msword':
      case 'application/access':
      case 'application/pdf':
      case 'application/excel':
      case 'application/vnd.ms-powerpoint':
      case 'application/vnd.oasis.opendocument.formula':
      case 'application/vnd.oasis.opendocument.text-master':
      case 'application/vnd.oasis.opendocument.database':
      case 'application/vnd.oasis.opendocument.formula':
      case 'application/vnd.oasis.opendocument.chart':
      case 'application/vnd.oasis.opendocument.graphics':
      case 'application/vnd.oasis.opendocument.presentation':
      case 'application/vnd.oasis.opendocument.speadsheet':
      case 'application/vnd.oasis.opendocument.text':
        break;

      case 'application/x-shockwave-flash':
        break;

      default:
        break;
    }


    return new Media\DefaultMedia($file, new \PHPExiftool\Exiftool());
  }

}
