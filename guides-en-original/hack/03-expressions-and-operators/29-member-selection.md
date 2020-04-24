The operator `->` is used to access instance properties and instance
methods on objects.

@@ member-selection-examples/IntBox.php @@

## Null Safe Member Access

The operator `?->` allows access to objects that [may be null](../types/nullable-types.md).

If the value is null, the result is null. Otherwise, `?->` behaves
like `->`.

``` Hack
function my_example(?IntBox $ib): ?int {
  return $ib?->getX();
}
```

Note that arguments are always evaluated, even if the object is
null. `$x?->foo(bar())` will call `bar()` even if `$x` is null.

## XHP Attribute Access

The operator `->:` is used for accessing XHP attributes.
