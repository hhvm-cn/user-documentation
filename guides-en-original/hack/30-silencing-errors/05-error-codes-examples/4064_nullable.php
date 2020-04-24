<?hh

namespace Hack\UserDocumentation\ErrorCodes\NullableMember;

class MyClass {
  public int $x = 0;
  public function foo(): void {}
}

function foo(?MyClass $m): void {
  /* HH_FIXME[4064] Accessing a property on a nullable object. */
  $value = $m->x;

  /* HH_FIXME[4064] Calling a method on a nullable object. */
  $m->foo();
}
