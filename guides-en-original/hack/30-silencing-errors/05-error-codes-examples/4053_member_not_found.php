<?hh

class MyClass {}

function takes_myclass(MyClass $c): void {
  /* HH_FIXME[4053] No such method. */
  $c->someMethod();
  /* HH_FIXME[4053] No such property. */
  $x = $c->someProperty;
}
