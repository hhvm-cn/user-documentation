namespace Hack\UserDocumentation\Functions\InoutParamsIndexing;

function set_to_value(inout int $item, int $value): void {
  $item = $value;
}

function use_it(): void {
  $items = vec[10, 11, 12];
  $index = 1;
  set_to_value(inout $items[$index], 42);

  // $items is now vec[10, 42, 12].
}
