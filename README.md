# HeltheTurbolinksBundle

The HeltheTurbolinksBundle integrates the [Helthe Turbolinks Component](https://github.com/helthe/Turbolinks)
with your Symfony2 application.

## Installation

### Step 1: Add package requirement in Composer

#### Manually

Add the following in your `componser.json`:

```json
{
    "require": {
        // ...
        "helthe/turbolinks-bundle": "~1.0"
    }
}
```

#### Using the command line

```bash
$ composer require 'helthe/turbolinks-bundle=~1.0'
```

### Step 2: Register the bundle in the kernel

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Helthe\Bundle\TurbolinksBundle\HeltheTurbolinksBundle(),
    );
}
```

### Step 3: Add Composer scripts for automatic installation of assets

```json
{
   "scripts": {
       "post-install-cmd": [
           "Helthe\\Bundle\\TurbolinksBundle\\Composer\\ScriptHandler::installAssets"
       ],
       "post-update-cmd": [
           "Helthe\\Bundle\\TurbolinksBundle\\Composer\\ScriptHandler::installAssets"
       ]
   }
}
```

## Usage

To start using turbolinks, all you need to do is add the turbolinks javascript to your layout.

Both the original coffeescript version and compiled version of each script are available for use.

### Inserting the javascript in your layout

#### Directly

```jinja
<script src="{{ asset('bundles/heltheturbolinks/js/turbolinks.js') }}"></script>
```

#### Using Assetic

```jinja
{% javascripts '@HeltheTurbolinksBundle/Resources/public/js/turbolinks.js' %}
    <script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %}
```

### Using jquery.turbolinks

If you need to use jquery.turbolinks, you need to add it before `turbolinks.js`

## Compatibility

Turbolinks is designed to work with any browser that fully supports pushState and
all the related APIs. This includes Safari 6.0+ (but not Safari 5.1.x!), IE10,
and latest Chromes and Firefoxes.

Do note that existing JavaScript libraries may not all be compatible with
Turbolinks out of the box due to the change in instantiation cycle. You might
very well have to modify them to work with Turbolinks' new set of events. For
help with this, check out the [Turbolinks Compatibility project](http://reed.github.io/turbolinks-compatibility).

## Additional Resources

Please refer to the [turbolinks](https://github.com/rails/turbolinks) and
[jquery.turbolinks](https://github.com/kossnocorp/jquery.turbolinks) projects
if you require additional information on the javascript libraries.

You will find additional documentation with the turbolinks component
[documentation](https://github.com/helthe/Turbolinks).

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/helthe/TurbolinksBundle/issues/new).
