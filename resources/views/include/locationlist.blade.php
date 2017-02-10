@foreach($location as $loc)
		@if($mod == "Province")
		<li href='{{$loc->province}}' data="{{$loc->id}}" class="list-group-item"><b>{{$loc->province}}</b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'Province')">Rename</a>/<a href="{{ route('setup.delete',['model'=>'Province','id'=>$loc->id])}}">Delete</a></span></li>
		@elseif($mod == "District")
		<li href='{{$loc->district}}' data="{{$loc->id}}" class="list-group-item"><b>{{$loc->district}}</b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'District')">Rename</a>/<a href="{{ route('setup.delete',['model'=>'District','id'=>$loc->id])}}">Delete</a></span></li>
		@elseif($mod == "catagory")
                <li href='{{$loc->category}}' data="{{$loc->id}}" class="list-group-item"><b>{{$loc->category}}</b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'Category')">Rename</a>/<a href="{{ route('organiser.delete',['model'=>'categories','id'=>$loc->id])}}">Delete</a></span></li>
                @elseif($mod == "regCenter")
                <option value="{{ $loc->id }}">{{ $loc->centerName }}</option>
                 
                @endif
@endforeach
                        