ACF YouTube Picker Field
================
Search and select videos on YouTube without leaving the page.

![ACF YouTube Picker Field](http://www.airesgoncalves.com.br/youtubepicker/acf-youtubepicker-v3.png)

- [Compatibility](#compatibility)
- [Installation](#installation)
- [Retrieving data](#retrieving-data)
- [Retrieving data - Single](#single)
- [Retrieving data - Multiple](#multiple)

Compatibility
================
This ACF field type is compatible with:
* ACF 5
* ACF 4

Installation
================
1. Copy the `acf-youtubepicker` folder into your `wp-content/plugins` folder
2. Activate the `YouTube Picker` plugin via the plugins admin page
3. Create a new field via ACF and select the `YouTube Picker` type

Retrieving data
================

#### Single
```php
// how to display data
$video = get_field( 'youtube_single_video' );

if( $video ) {
  echo '<h1>' . $video['title'] . '</h1>';
  echo '<img src="' . $video['thumbs']['default']['url'] . '">';
}
```

```php
$video = get_field('youtube_single_video');

print_r( $video );

// Output
Array
(
  [title] => Rio 2016
  [vid] => Z00jjc-WtZI
  [url] => https://www.youtube.com/watch?v=Z00jjc-WtZI
  [duration] => 00:02:23
  [thumbs] => Array
      (
          [default] => Array
              (
                  [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/default.jpg
                  [width] => 120
                  [height] => 90
              )

          [medium] => Array
              (
                  [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/mqdefault.jpg
                  [width] => 320
                  [height] => 180
              )

          [high] => Array
              (
                  [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/hqdefault.jpg
                  [width] => 480
                  [height] => 360
              )

          [standard] => Array
              (
                  [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/sddefault.jpg
                  [width] => 640
                  [height] => 480
              )

          [maximum] => Array
              (
                  [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/maxresdefault.jpg
                  [width] => 640
                  [height] => 480
              )

      )
  [iframe] => <iframe src="https://www.youtube.com/embed/Z00jjc-WtZI" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
)
```

#### Multiple
```php
// how to display data
$videos = get_field( 'youtube_multiple_videos' );

if( $videos ) {
  foreach( $videos as $v ) {
    echo '<h1>' . $v['title'] . '</h1>';
    echo '<img src="' . $v['thumbs']['default']['url'] . '">';
  }
}
```

```php
$videos = get_field('youtube_multiple_videos');

print_r( $videos );

// Output
Array
(
  [0] => Array
    (
        [title] => Rio 2016
        [vid] => Z00jjc-WtZI
        [url] => https://www.youtube.com/watch?v=Z00jjc-WtZI
        [duration] => 00:02:23
        [thumbs] => Array
            (
                [default] => Array
                    (
                        [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/default.jpg
                        [width] => 120
                        [height] => 90
                    )

                [medium] => Array
                    (
                        [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/mqdefault.jpg
                        [width] => 320
                        [height] => 180
                    )

                [high] => Array
                    (
                        [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/hqdefault.jpg
                        [width] => 480
                        [height] => 360
                    )

                [standard] => Array
                    (
                        [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/sddefault.jpg
                        [width] => 640
                        [height] => 480
                    )

                [maximum] => Array
                    (
                        [url] => http://i1.ytimg.com/vi/Z00jjc-WtZI/maxresdefault.jpg
                        [width] => 640
                        [height] => 480
                    )

            )
        [iframe] => <iframe src="https://www.youtube.com/embed/Z00jjc-WtZI" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
    )
)
```
