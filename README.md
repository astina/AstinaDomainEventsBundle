Astina Domain Events Bundle
===========================

Configure services as Doctrine domain event listeners.

**Note**: this bundle is not production ready as it requires the master version of DoctrineBundle.

## Installation

### Step 1: Add to composer.json

```json
"require":  {
    "astina/domain-events-bundle":"dev-master",
}
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Astina\Bundle\DomainEventsBundle\AstinaDomainEventsBundle(),
    );
}
```

##Usage

Create subscriber service:

```php
class ProductSupplyWatcher
{
    public function preUpdate(ProductSupply $supply, PreUpdateEventArgs $event)
    {
        // do stuff
    }
}

```
Read more about the (optional) $event parameter in the [Doctrine documentation about Entity Listeners](https://doctrine-orm.readthedocs.org/en/latest/reference/events.html?highlight=events#entity-listeners).

```yml
<service id="product_supply_watcher" class="Astina\Bundle\SandboxBundle\Foo\ProductSupplyWatcher">
    <argument type="service" id="some_service" />
</service>
```

Configure domain event subscriber:

```yaml
astina_domain_events:
    subscribers:
        product_supply_watcher: # this is the service id
            entity: Astina\Bundle\ShopBundle\Model\ProductSupply # entity class
            events: [ preUpdate ] # list of events to listen to
```

Note that the method name in the subscriber service corresponds with the event name.

Available events:
- prePersist
- postPersist
- preUpdate
- postUpdate
- preRemove
- postRemove
- preFlush
- postLoad

##Todo
Add possibility to subscribe to changes on specific fields.
