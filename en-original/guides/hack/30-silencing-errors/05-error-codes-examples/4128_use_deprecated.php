<?hh

function foo_new(): void {}

<<__Deprecated("Use foo_new instead")>>
function foo_old(): void {}

function bar(): void {
  /* HH_FIXME[4128] Calling a deprecated function. */
  foo_old();
}
