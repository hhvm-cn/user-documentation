<?hh

namespace Hack\UserDocumentation\ErrorCodes\UnboundName;

function foo(): void {
  /* HH_FIXME[4107] No such function (type checking). */
  /* HH_FIXME[2049] No such function (global name check). */
  nonexistent_function();
}
