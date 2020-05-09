<?hh

namespace Hack\Attributes\NewableComplete;

<<__ConsistentConstruct>>
abstract class A {
  public function __construct(int $x, int $y) {}
}

class B extends A {}

function f<<<__Newable>> reify T as A>(int $x, int $y): T {
  return new T($x,$y);
}

<<__EntryPoint>>
function main(): void {
  f<B>(3,4);             // success, equivalent to new B(3,4)
}
