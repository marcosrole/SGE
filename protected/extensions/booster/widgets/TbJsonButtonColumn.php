<?php
/**
 *## TbJsonButtonColumn class file
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.TbButtonColumn');

/**
 *## JsonButtomColumn widget
 *
 * Works in conjunction with TbJsonGridView. Renders HTML or returns JSON according to the request to the Grid.
 *
 * @property TbJsonGridView $grid
 *
 * @package bootstrap.widgets.grids.columns.json
 */
class TbJsonButtonColumn extends TbButtonColumn
{
	/**
	 * Renders|returns the header cell.
	 */
	public function renderHeaderCell()
	{
		if ($this->grid->json) {
			ob_start();
			$this->renderHeaderCellContent();
			$content = ob_get_contents();
			ob_end_clean();

			return array('id' => $this->id, 'content' => $content);
		}
		parent::renderHeaderCell();
	}

	/**
	 * Renders|returns the data cell
	 *
	 * @param int $row
	 *
	 * @return array|void
	 */
	public function renderDataCell($row)
	{
		if ($this->grid->json) {
            $data = $this->grid->dataProvider->data[$row];
            $options = $this->htmlOptions;
            if ($this->cssClassExpression !== null) {
                $class = $this->evaluateExpression($this->cssClassExpression, array('row' => $row, 'data' => $data));
                if (!empty($class)) {
                    if (isset($options['class'])) {
                        $options['class'] .= ' ' . $class;
                    } else {
                        $options['class'] = $class;
                    }
                }
            }

            return array(
                'attrs' => CHtml::renderAttributes($options),
                'content' => $this->renderDataCellContent($row, $data),
            );
		}

		parent::renderDataCell($row);
	}

    protected function renderDataCellContent($row, $data)
    {
        ob_start();
        parent::renderDataCellContent($row, $data);
        $html = ob_get_contents();
        ob_end_clean();

        if ($this->grid->json) {
            return $html;
        }

        echo $html;
    }

	/**
	 * Initializes the default buttons (view, update and delete).
	 */
	protected function initDefaultButtons()
	{
		parent::initDefaultButtons();
		/**
		 * add custom with msgbox instead
		 */
		$this->buttons['delete']['click'] = strtr(
			$this->buttons['delete']['click'],
			array('yiiGridView' => 'yiiJsonGridView')
		);
	}
}
