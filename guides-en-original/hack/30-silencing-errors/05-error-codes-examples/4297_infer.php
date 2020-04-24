<?hh

namespace Hack\UserDocumentation\ErrorCodes\InferenceFailed;

class MyA {
  public function doStuff(): void {}
}

function foo(): void {
  /* HH_FIXME[4297] Cannot infer the type of $x. */
  $f = $x ==> $x->doStuff();

  $f(new MyA());
}
