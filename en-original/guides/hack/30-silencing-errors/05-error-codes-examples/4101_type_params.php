<?hh

namespace Hack\UserDocumentation\ErrorCodes\TypeParamArity;

class MyBox<T> {
  public ?T $x = null;
}

/* HH_FIXME[4101] Missing a type parameter. */
class TooFewArguments extends MyBox {}

/* HH_FIXME[4101] Too many type parameters. */
class TooManyArguments extends MyBox<mixed, mixed> {}
