<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Files;

/**
 * DocumentsTableSearch represents the model behind the search form of `app\models\DocumentsTable`.
 */
class FilesSearch extends Files
{
    public $startDate;
    public $endDate;
    /**
     * {@inheritdoc}        
     */
    public function rules()
    {
        return [
            [['FileID'], 'integer'],
            [['FileData', 'FileName', 'FileType', 'ContentType'], 'string'],
            [['CreatedAt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Files::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->FileID,
        ]);

        if ($this->CreatedAt) {
            list($this->startDate, $this->endDate) = explode(' - ', $this->CreatedAt);
            $query->andFilterWhere(['between', 'CreatedAt', $this->startDate, $this->endDate]);
        }

        $query
            ->andFilterWhere(['like', 'FileData', $this->FileData])
            ->andFilterWhere(['like', 'FileName', $this->FileName])
            ->andFilterWhere(['like', 'FileType', $this->FileType])
            ->andFilterWhere(['like', 'ContentType', $this->ContentType]);

        return $dataProvider;
    }
}
