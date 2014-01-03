<?php
class XF_Page
{
	/**
	 * 分页方法
	 * 调用方法：XF_Page::generatePage('index.php?page=', 200, 1);
	 * 显示效果：1 2 3 4 5 6 7 8 9 10 11 下一页>
	 */
	public static function generatePage($url, $totalNum, $currPage, $pageSize=10)
	{
		$maxDisplay = 11;
		$html = '';
		$maxPageNum = ceil($totalNum / $pageSize);
  
		if($maxPageNum <= 1)
		{
			return $html;
		}

		if($maxPageNum < $currPage)
		{
			$currPage = $maxPageNum;
		}
		$begin = max(1, $currPage - 5);
		$end = min($begin + $maxDisplay - 1, $maxPageNum);
		$begin = min(max(1, $end - $maxDisplay + 1), $begin);

		if($currPage > 1)
		{
			$html .= '<a class="prev" href="' . $url . ($currPage - 1) . '">&lt;上一页</a> ';
		}
		for($i = $begin; $i <= $end; $i++)
		{
			if($i == $currPage)
			{
				$html .= '<span class="current">' . $currPage . "</span> ";
			}
			else
			{
				$html .= '<a href="'. $url . $i . '">' . $i . '</a> ';
			}
		}
		if($currPage < $maxPageNum)
		{
			$html .= '<a class="next" href="' . $url . ($currPage + 1) . '">下一页&gt;</a>';
		}

		return $html;
	}
}
