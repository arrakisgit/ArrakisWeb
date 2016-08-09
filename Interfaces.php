<?php
interface Channel
{
	
	public function Categories();
	public function Shows($categorySelected);
	public function Episodes($categorySelected,$showSelected);
	public function Live();
	public function Descriptions($categorySelected,$showSelected,$EpisodeSelected);
	public function Images($categorySelected,$showSelected,$EpisodeSelected);
	public function Durations($categorySelected,$showSelected,$EpisodeSelected);
	
}
?>