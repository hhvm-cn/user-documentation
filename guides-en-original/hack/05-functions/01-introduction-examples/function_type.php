<?hh

namespace Hack\UserDocumentation\Functions\FunctionType;

function apply_func(int $v, (function(int): int) $f): int {
  return $f($v);
}

function usage_example(): void {
  $x = apply_func(0, $x ==> $x + 1);
}
