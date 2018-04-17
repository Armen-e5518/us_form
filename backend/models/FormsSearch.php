<?php

namespace backend\models;

use common\models\User;
use common\models\UsersForms;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Forms;

/**
 * FormsSearch represents the model behind the search form about `common\models\Forms`.
 */
class FormsSearch extends Forms
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'name', 'html', 'email', 'email_subject', 'email_text', 'thank_title', 'thank_text'], 'safe'],
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

        $domain = Yii::$app->params['domain'];
        $url = $domain . '/forms/site/view?id=';
        $query = Forms::find();
        $query->select(['id', 'CONCAT("' . (string)$url . '",url) as url', 'name', 'email_subject', 'thank_title', 'email']);

        $UsersForm = UsersForms::GetUsersFormsByThisUser();
        if ($UsersForm['rol'] == 'ADMIN' && !empty($UsersForm['data'])) {
            $query->where((['in', 'id', $UsersForm['data']]));
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['id' => SORT_DESC]),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'html', $this->html])
            ->andFilterWhere(['like', 'email_subject', $this->email])
            ->andFilterWhere(['like', 'email_subject', $this->email_subject])
            ->andFilterWhere(['like', 'email_text', $this->email_text])
            ->andFilterWhere(['like', 'thank_title', $this->thank_title])
            ->andFilterWhere(['like', 'thank_text', $this->thank_text]);

        return $dataProvider;
    }
}
