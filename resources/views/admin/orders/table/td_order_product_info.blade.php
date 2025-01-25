<td style="width: 10%">
                                        <div
                                            style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                                            @foreach ($order['items'] as $item)
                                            <div
                                                style="display: flex; align-items: center; gap: 10px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                                <div>
                                                    <img src="{{ asset($item['product_info']['featured_image']) }}"
                                                        width="50" height="50" />
                                                </div>
                                                <div>
                                                    <span title="{{ $item['product_info']['product_name'] }}"
                                                        style="cursor: pointer;">
                                                        {{ Str::limit($item['product_info']['product_name'], 11, '...') }}
                                                    </span><br>
                                                    <span>Code:
                                                        {{ Str::limit($item['product_info']['product_code'], 5, '...') }}</span><br>
                                                    <span>Quantity: {{ $item['quantity'] }}</span><br>
                                                    @foreach ($item['option'] as $option)
                                                    <span>{{ $option['attributeOption']['attribute']['name'] }}:
                                                        {{ $option['attributeOption']['name'] }}</span><br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>