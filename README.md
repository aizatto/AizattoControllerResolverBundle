README
======

When it comes to Symfony development, I prefer one controller per endpoint.
This is because my experience with Symfony has resulted in many fat controllers,
and it has become easier to manage the controllers when it is one endpoint per
controller.

When you begin developing a Symfony application, you will put actions related
to a particular model into one controller. This would result in an extermely
large (in terms of lines of code) controller.

Then you'll move those actions into a different controller.

So I wanted an easy way to standardize the function that gets called for each
controller.

Example Controller:

<pre>
class DefaultController extends Controller {
  
  public function getResponse() {
    return new Response($content);
  }

}
</pre>

Example Route:

<pre>
aizatto_controller_resolver_bundle_default:
    pattern: /
    defaults: { _controller: "AizattoControllerResolverBundle:Default" }
</pre>

Installation
------------

### Install source code

You have two options to install the source code.

* deps file
* git submodules

#### Install via deps

Add into your deps file

<pre>
[AsseticBundle]
     git=http://github.com/aizatto/AizattoControllerResolverBundle.git
     target=/bundles/Aizatto/Bundle/ControllerResolverBundle
</pre>

Execute vendor update script:

<pre>
php bin/vendors update
</pre>

#### Install via git submodules

Execute git submodule add command:

<pre>
git submodule add \
  http://github.com/aizatto/AizattoControllerResolverBundle.git \
  vendor/bundles/Aizatto/Bundle/ControllerResolverBundle
</pre>

### Install into AppKernel

Edit your AppKernel (app/AppKernel.php), add the following line in the
'dev', and 'test' environment only Bundles.

<pre>
if (in_array($this->getEnvironment(), array('dev', 'test'))) {
  ...
  $bundles[] = new Aizatto\Bundle\ControllerResolverBundle\ControllerResolverBundle();
  ...
}
</pre>

### Install into autoload

Edit app/autoload.php, and add the register the namespace "Aizatto":

<pre>
$loader->registerNamespaces(array(
  'Aizatto' => __DIR__.'/../vendor/bundles',
))
</pre>


### Install route

We have to write the routes individually for each controller.

For example if we have the controller "DefaultController" in your bundle
"AizattoControllerResolverBundle".

We add to app/config/routing.yml:

<pre>
aizatto_controller_resolver_bundle_default:
    pattern: /
    defaults: { _controller: "AizattoControllerResolverBundle:Default" }
</pre>

Then visit in your brower http://localhost/dev.php/
