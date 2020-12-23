@foreach($items as $item)
    @if(is_null($item->perms) || auth()->user()->can([$item->perms.'-view']))
        @if(!$item->hasChildren())
            <a href="{!! $item->url() !!}" class="{{ $item->isActive ? 'active' : '' }} item" tabindex="{{ $item->id }}">
                <i class="{{ $item->icon }} icon"></i>{!! $item->title !!}
            </a>
        @else
            <div class="ui title {{ $item->title == $subtitle ? 'active' : '' }}" tabindex="{{ $item->id }}">
                <i class="{{ $item->icon }} icon"></i>
                {!! $item->title !!}
                <i class="dropdown right icon" style="float:right"></i>
            </div>
            <div class="ui content {{ $item->isActive ? 'active' : '' }}">
            @foreach ($item->children() as $child)
                @if(is_null($child->perms) || auth()->user()->can([$child->perms.'-view']) || auth()->user()->can([$child->link->path['url']]))
                    @if(!$child->hasChildren())
                        <a href="{!! $child->url() !!}" class="{{ $child->isActive ? 'active' : '' }} item">
                            <i class="{{ $child->isActive ? 'caret right' : '' }} icon"></i>{!! $child->title !!}
                        </a>
                    @else
                        <div class="accordion">
                            <div class="title {{ $child->isActive ? 'active' : '' }}">
                                <i class="{{ $child->isActive ? 'caret right' : '' }} icon"></i>
                                {!! $child->title !!}
                                <i class="dropdown right icon" style="float: right;"></i>
                            </div>
                            <div class="content {{ $child->isActive ? 'active' : '' }}">
                                @foreach ($child->children() as $grandChild)
                                    @if(is_null($grandChild->perms) || auth()->user()->can([$grandChild->perms.'-view']) || auth()->user()->can([$grandChild->link->path['url']]))
                                        <a href="{!! $grandChild->url() !!}" class="{{ $grandChild->isActive ? 'active' : '' }} item">
                                            <i class="{{ $grandChild->isActive ? 'caret right' : '' }} icon"></i>{!! $grandChild->title !!}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
        @endif
    @endif
@endforeach