<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use frontend\models\Advertiser;
use common\models\User;

/**
 * AdvetiserSearch represents the model behind the search form about `frontend\models\Advetiser`.
 */
class AdvertiserSearch extends Advertiser
{
    const ITEMS_PER_PAGE = 10;
    /**
     * @inheritdoc
     */
    public
        $name,
        $location,
	$date_range,
	$date_range_start,
	$date_range_end,
        $age_lower,
        $age_upper,
        $height_lower,
        $height_upper,
        $price_upper,
        $price_lower,
        $weight_lower,
        $weight_upper,
        $shoe_size_lower,
        $shoe_size_upper,

        $color_hair,
        $s_hair_id = array(),//for search model

        $color_eye,
        $s_eye_id = array(),//for search model

        $color_skin,
        $s_skin_id = array(),//for search model

        $nationality_data,
        $s_nationality_id = array(),//for search model

        $s_bra_id = array(),//for search model
        $filtersex = [],
        $bra_groups;

    public function rules()
    {
        return [
            [['id', 'user_id','cities_id',
                'price', 'price_lower', 'price_upper',
                'age', 'age_lower', 'age_upper',
                'height', 'height_lower', 'height_upper',
                'weight', 'weight_lower', 'weight_upper',
                'shoe_size_lower', 'shoe_size_upper',
                'silicone', 'online'], 'integer'],
            [['title', 'date', 'offering', 'receiving', 'desc', 's_hair_id', 's_eye_id', 's_skin_id', 's_nationality_id', 's_bra_id', 'name', 'location', 'date_range_start', 'date_range_end', 'date_range', 'filtersex'], 'safe'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Advertiser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'hair_id' => $this->hair_id,
            'eye_id' => $this->eye_id,
            'skin_id' => $this->skin_id,
            'online' => $this->online,
            'nationality_id'=> $this->nationality_id,
            'bra_id' => $this->bra_id,
        ]);
        if (!empty($this->silicone)) {
          $query->andFilterWhere(['silicone' => $this->silicone]);
        }
        $query->joinWith(['user']);
        $query->andFilterWhere(['user.status' => User::STATUS_ACTIVE]);
        if($this->name)
        {
            $query->andFilterWhere(['like', 'user.username', $this->name]);
        }
        if($this->location)
        {
            $location = explode(",", $this->location);
            if(count($location)<2){
                $query->joinWith(['country']);
                $query->andFilterWhere(['like', 'country.title', trim($location[0])]);
            }
            else{
                $query->joinWith(['city']);
                $query->andFilterWhere(['like', 'city.title', trim($location[0])]);
                $query->joinWith(['country']);
                $query->andFilterWhere(['like', 'country.title', trim($location[1])]);
            }
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            //->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'nationality_id', $this->nationality_id])
            ->andFilterWhere(['like', 'desc', $this->desc]);
        $this->likes($this->receiving,$query,'receiving');
        $this->likes($this->offering,$query,'offering');
        $this->checkbox($this->s_hair_id,$query,'hair_id');
        $this->checkbox($this->s_skin_id,$query,'skin_id');
        $this->checkbox($this->s_eye_id,$query,'eye_id');
        $this->in($this->s_nationality_id,$query,'nationality_id');
        $this->in($this->s_bra_id,$query,'bra_id');
        $this->between('price',$query,$this->price_lower,$this->price_upper);
        $this->between('age',$query,$this->age_lower,$this->age_upper);
        $this->between('height',$query,$this->height_lower,$this->height_upper);
        $this->between('weight',$query,$this->weight_lower,$this->weight_upper);
        $this->between('shoe_size',$query,$this->shoe_size_lower,$this->shoe_size_upper);
        if (!empty($this->filtersex)) {
          $query->andFilterWhere(['in', 'sex_id', $this->filtersex]);
        }

		if ($this->date_range) {
			$parts = explode(' - ', $this->date_range);
			$query->availableInDateRange($parts[0], $parts[1]);
		}

        return $dataProvider;
    }

    private function between($field,$query,$lower,$upper)
    {
        if(empty($lower)){
            if(!empty($upper)){
                $query->andFilterWhere(['<=', $field, $upper]);
            }
        }
        else{
            if(!empty($upper)){
                $query->andFilterWhere(['and', "$field>=$lower", "$field<=$upper"]);
            }
            else{
                $query->andFilterWhere(['>=', $field, $lower]);
            }
        }
    }

    private function likes($field,$query,$field_name)
    {
        if(!empty($field))
        {
            foreach($field as $value)
            {
                $query->andFilterWhere(['like', $field_name, ','.$value.',']);
            }
        }
    }

    public function checkbox($field,$query,$field_name)
    {

        if(!empty($field))
        {
            $exp = array('or');
            foreach($field as $value)
            {
                $exp[]=['like', $field_name,$value];
            }

            $query->andFilterWhere($exp);
        }
    }

    public function in($field,$query,$field_name)
    {
        if(!empty($field))
        {
            $query->andWhere([$field_name => explode(',', implode(',', $field))]);
        }
    }
}
