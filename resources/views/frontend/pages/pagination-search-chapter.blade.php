
                        @foreach($chuong as $key => $value)
                        <a class="pt-10 pb-10 pl-10 hover-chapter border-bottom color-black" href="{{route('chuongtruyen',[$truyen->slug,$value->slug])}}" title="{{$value->chapter_number}}:{{$value->name_chapter}}">
                            <div class="chapter-panel-item">
                                <div class="chapter-panel-name"><span class="has-text-weight-bold pr-2">{{$value->chapter_number}}: </span> <span>{{$value->name_chapter}}</span></div>
                                <div class="is-italic is-small is-primary">
                                    Cập nhật:
                                    <span auto-update="true">{{$value->created_at->diffForHumans($now)}}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        @if($chuong->lastPage()>1)
                        <ul class="flex pl-10 pt-20">
                            @for($i=1;$i<=$chuong->lastPage();$i++)
                            @if ($from < $i && $i <= $to)
                            <li class="mr-5px paginate"><a class="btn btn-sm btn-outline-secondary {{$chuong->currentPage()==$i?'active':''}}" href="{{$chuong->url($i)}}">{{$i}}</a></li>
                            @endif
                            @endfor
                            <li class="ml-20 mr-5px paginate {{$chuong->currentPage()==$chuong->lastPage()||$chuong->currentPage()==$chuong->lastPage()-1||$chuong->currentPage()==$chuong->lastPage()-2?'display-none':''}}"><a class="btn btn-sm btn-outline-secondary uppercase" href="{{$chuong->url($chuong->lastPage())}}">{{$chuong->lastPage()}}</a></li>

                            <li class="ml-20 mr-5px paginate"><a class="btn btn-sm btn-outline-secondary uppercase {{$chuong->currentPage()<=1?'disabled':''}}" href="{{$chuong->previousPageUrl()}}"><i class="fas fa-chevron-left font-size-10"></i></a></li>
                            <li class="mr-5px paginate"><a class="btn btn-sm btn-outline-secondary uppercase {{$chuong->currentPage()>=$chuong->lastPage()?'disabled':''}}" href="{{$chuong->nextPageUrl()}}"><i class="fas fa-chevron-right font-size-10"></i></a></li>
                        </ul>
                        @endif