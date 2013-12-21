# HeltheTurbolinksBundle

The HeltheTurbolinksBundle is a direct port of the rails [turbolinks](https://github.com/rails/turbolinks) gem
and [jquery.turbolinks](https://github.com/kossnocorp/jquery.turbolinks) gem for your Symfony2 application.

## Versions

Current library versions used:

 * turbolinks: v2.1.0
 * jquery.turbolinks: v2.0.1

## Installation

### Step 1: Composer

Add the following in your `componser.json`:

```json
    {
        "require": {
            // ...
            "helthe/turbolinks-bundle": "dev-master"
        }
    }
```

### Step 2: Register the bundle

```php
    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Helthe\Bundle\TurbolinksBundle(),
        );
    }
```


## Usage

Both the original coffeescript version and compiled version of each script are available for use.

### Using turbolinks.js

To enable turbolinks, all you need to do is add the turbolinks javascript to your layout.

#### Inserting the asset directly

```twig
    <script src="{{ asset('bundles/heltheturbolinks/js/turbolinks.js') }}"></script>
```

#### Using Assetic

```twig
    {% javascripts
      '@HeltheTurbolinksBundle/Resources/public/js/turbolinks.js'
    %}
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

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/helthe/TurbolinksBundle/issues/new).
