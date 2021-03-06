<?php use thebuggenie\core\entities\LogItem;

if ($item instanceof \thebuggenie\core\entities\LogItem) {

    $previous_value = null;
    $new_value = null;
    try {

        switch ($item->getChangeType()) {
            case LogItem::ACTION_ISSUE_CREATED:
                echo fa_image_tag('file-alt', ['class' => 'log_issue_created']);
                echo __('The issue was created');
                break;
            case LogItem::ACTION_ISSUE_CLOSE:
                echo fa_image_tag('check-square', ['class' => 'log_issue_closed'], 'far');
                echo __('The issue was closed');
                break;
            case LogItem::ACTION_ISSUE_REOPEN:
                echo fa_image_tag('external-link-square', ['class' => 'log_issue_reopen']);
                echo __('The issue was reopened');
                break;
            case LogItem::ACTION_ISSUE_UPDATE_RELATED_ISSUE:
                echo fa_image_tag('link', ['class' => 'log_issue_depends']);
                echo __('The issues dependency changed: %change', ['%change' => '<strong>' . $item->getText() . '</strong>']);
                break;
            case LogItem::ACTION_ISSUE_UPDATE_FREE_TEXT:
                echo fa_image_tag('edit', ['class' => 'log_issue_update']);
                echo __('The issue was updated: %change', ['%change' => '<strong>' . $item->getText() . '</strong>']);
                if (trim($item->getPreviousValue()) || trim($item->getCurrentValue())) {
                    echo '<br>';
                    echo tbg_template_escape($item->getPreviousValue()) . ' &rArr; ' . tbg_template_escape($item->getCurrentValue());
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_TITLE:
                echo fa_image_tag('edit', ['class' => 'log_issue_title']);
                echo __('Title updated from %previous_value to %new_value', ['%previous_value' => '<strong>' . tbg_template_escape($item->getPreviousValue()) . '</strong>', '%new_value' => '<strong>' . tbg_template_escape($item->getCurrentValue()) . '</strong>']);
                break;
            case LogItem::ACTION_ISSUE_UPDATE_DESCRIPTION:
                echo fa_image_tag('edit', ['class' => 'log_issue_title']);
                echo __('Description updated');
                break;
            case LogItem::ACTION_ISSUE_UPDATE_STATUS:
                $new_item = \thebuggenie\core\entities\Status::getB2DBTable()->selectById($item->getCurrentValue());
                $background_color = ($new_item instanceof \thebuggenie\core\entities\Status) ? $new_item->getColor() : '#FFF';
                $text_color = ($new_item instanceof \thebuggenie\core\entities\Status) ? $new_item->getTextColor() : '#000';
                echo fa_image_tag('flag', ['class' => 'log_issue_status', 'style' => "background-color: {$background_color}; color: {$text_color};"]);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Status::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Status::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Status changed from %previous_value to %new_value by  %who_value", ['%previous_value' => get_component_html('main/statusbadge', ['status' => $old_item]), '%new_value' => get_component_html('main/statusbadge', ['status' => $new_item]), '%who_value' => '<strong>' . $item->getUser() . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_RESOLUTION:
                echo fa_image_tag('tasks', ['class' => 'log_issue_resolution']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Resolution::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Resolution::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Resolution changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_PRIORITY:
                echo fa_image_tag('exclamation-circle', ['class' => 'log_issue_priority']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Priority::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Priority::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Priority changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_SEVERITY:
                echo fa_image_tag('exclamation-circle', ['class' => 'log_issue_severity']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Severity::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Severity::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Severity changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_REPRODUCABILITY:
                echo fa_image_tag('repeat', ['class' => 'log_issue_reproducability']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Reproducability::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Reproducability::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Reproducability changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_ISSUETYPE:
                echo fa_image_tag('file-code', ['class' => 'log_issue_type']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Issuetype::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Issuetype::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Issuetype changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_CATEGORY:
                echo fa_image_tag('chart-pie', ['class' => 'log_issue_category']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Category::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Category::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Category changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_MILESTONE:
                echo fa_image_tag('flag-checkered', ['class' => 'log_issue_milestone']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\Milestone::getB2DBTable()->selectById($item->getPreviousValue())) ? __($old_item->getName()) : __('Unknown')) : __('Not determined');
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\Milestone::getB2DBTable()->selectById($item->getCurrentValue())) ? __($new_item->getName()) : __('Unknown')) : __('Not determined');
                    echo __("Milestone changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_OWNER:
                echo fa_image_tag('user-plus', ['class' => 'log_issue_owned']);
                if ($item->hasChangeDetails()) {
                    echo __("Owned by changed to %user", ['%user' => '<strong>' . $item->getText() . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_POSTED_BY:
                echo fa_image_tag('user', ['class' => 'log_issue_posted']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\User::getB2DBTable()->selectById($item->getPreviousValue())) ? get_component_html('main/userdropdown_inline', ['user' => $old_item]) : '<strong>' . __('Unknown') . '</strong>') : '<strong>' . __('Not determined') . '</strong>';
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\User::getB2DBTable()->selectById($item->getCurrentValue())) ? get_component_html('main/userdropdown_inline', ['user' => $new_item]) : '<strong>' . __('Unknown') . '</strong>') : '<strong>' . __('Not determined') . '</strong>';
                    echo __("Posted by changed from %previous_value to %new_value", ['%previous_value' => $previous_value, '%new_value' => $new_value]);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_CUSTOMFIELD:
                if ($item->hasChangeDetails()) {
                    $key_data = explode(':', $item->getText());
                    $key = $key_data[0];
                    $customdatatype = \thebuggenie\core\entities\CustomDatatype::getByKey($key);
                    if ($customdatatype instanceof \thebuggenie\core\entities\CustomDatatype) {
                        $old_value = $item->getPreviousValue();
                        $new_value = $item->getCurrentValue();
                        switch ($customdatatype->getType()) {
                            case \thebuggenie\core\entities\CustomDatatype::INPUT_TEXT:
                            case \thebuggenie\core\entities\CustomDatatype::INPUT_TEXTAREA_SMALL:
                            case \thebuggenie\core\entities\CustomDatatype::INPUT_TEXTAREA_MAIN:
                                $old_value = tbg_template_escape($item->getPreviousValue());
                                $new_value = tbg_template_escape($item->getCurrentValue());
                                echo fa_image_tag('edit', ['class' => 'log_issue_customfield']);

                                break;
                            case \thebuggenie\core\entities\CustomDatatype::DATE_PICKER:
                            case \thebuggenie\core\entities\CustomDatatype::DATETIME_PICKER:
                                echo fa_image_tag('calendar', ['class' => 'log_issue_customfield']);

                                $old_value = ($old_value != null) ? date('Y-m-d' . ($customdatatype->getType() == \thebuggenie\core\entities\CustomDatatype::DATETIME_PICKER ? ' H:i' : ''), (int)$old_value) : \thebuggenie\core\framework\Context::getI18n()->__('Not determined');
                                $new_value = ($new_value != null) ? date('Y-m-d' . ($customdatatype->getType() == \thebuggenie\core\entities\CustomDatatype::DATETIME_PICKER ? ' H:i' : ''), (int)$new_value) : \thebuggenie\core\framework\Context::getI18n()->__('Not determined');
                                break;
                            case \thebuggenie\core\entities\CustomDatatype::EDITIONS_CHOICE:
                            case \thebuggenie\core\entities\CustomDatatype::COMPONENTS_CHOICE:
                            case \thebuggenie\core\entities\CustomDatatype::RELEASES_CHOICE:
                            case \thebuggenie\core\entities\CustomDatatype::STATUS_CHOICE:
                                echo fa_image_tag('cubes', ['class' => 'log_issue_customfield component']);
                                $old_object = null;
                                $new_object = null;
                                try {
                                    switch ($customdatatype->getType()) {
                                        case \thebuggenie\core\entities\CustomDatatype::EDITIONS_CHOICE:
                                            $old_object = \thebuggenie\core\entities\Edition::getB2DBTable()->selectById($old_value);
                                            break;
                                        case \thebuggenie\core\entities\CustomDatatype::COMPONENTS_CHOICE:
                                            $old_object = \thebuggenie\core\entities\Component::getB2DBTable()->selectById($old_value);
                                            break;
                                        case \thebuggenie\core\entities\CustomDatatype::RELEASES_CHOICE:
                                            $old_object = \thebuggenie\core\entities\Build::getB2DBTable()->selectById($old_value);
                                            break;
                                        case \thebuggenie\core\entities\CustomDatatype::STATUS_CHOICE:
                                            $old_object = \thebuggenie\core\entities\Status::getB2DBTable()->selectById($old_value);
                                            break;
                                    }
                                } catch (\Exception $e) {
                                }
                                try {
                                    switch ($customdatatype->getType()) {
                                        case \thebuggenie\core\entities\CustomDatatype::EDITIONS_CHOICE:
                                            $new_object = \thebuggenie\core\entities\Edition::getB2DBTable()->selectById($new_value);
                                            break;
                                        case \thebuggenie\core\entities\CustomDatatype::COMPONENTS_CHOICE:
                                            $new_object = \thebuggenie\core\entities\Component::getB2DBTable()->selectById($new_value);
                                            break;
                                        case \thebuggenie\core\entities\CustomDatatype::RELEASES_CHOICE:
                                            $new_object = \thebuggenie\core\entities\Build::getB2DBTable()->selectById($new_value);
                                            break;
                                        case \thebuggenie\core\entities\CustomDatatype::STATUS_CHOICE:
                                            $new_object = \thebuggenie\core\entities\Status::getB2DBTable()->selectById($new_value);
                                            break;
                                    }
                                } catch (\Exception $e) {
                                }
                                $old_value = (is_object($old_object)) ? $old_object->getName() : \thebuggenie\core\framework\Context::getI18n()->__('Unknown');
                                $new_value = (is_object($new_object)) ? $new_object->getName() : \thebuggenie\core\framework\Context::getI18n()->__('Unknown');
                                break;
                            default:
                                echo fa_image_tag('edit', ['class' => 'log_issue_customfield']);
                                $old_item = null;
                                $new_item = null;
                                try {
                                    $old_item = ($old_value) ? new \thebuggenie\core\entities\CustomDatatypeOption($old_value) : null;
                                } catch (\Exception $e) {
                                }
                                try {
                                    $new_item = ($new_value) ? new \thebuggenie\core\entities\CustomDatatypeOption($new_value) : null;
                                } catch (\Exception $e) {
                                }
                                $old_value = ($old_item instanceof \thebuggenie\core\entities\CustomDatatypeOption) ? $old_item->getName() : \thebuggenie\core\framework\Context::getI18n()->__('Unknown');
                                $new_value = ($new_item instanceof \thebuggenie\core\entities\CustomDatatypeOption) ? $new_item->getName() : \thebuggenie\core\framework\Context::getI18n()->__('Unknown');
                                break;
                        }
                        echo __("%field_name changed from %previous_value to %new_value", ['%field_name' => $customdatatype->getName(), '%previous_value' => '<strong>' . $old_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                    } else {
                        echo fa_image_tag('edit', ['class' => 'log_issue_customfield']);
                        echo __('Custom field changed');
                    }
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_PAIN_BUG_TYPE:
                echo fa_image_tag('edit', ['class' => 'log_issue_pain_bugtype']);
                if ($item->hasChangeDetails()) {
                    $previous_value = $item->getPreviousValue() ? \thebuggenie\core\entities\Issue::getPainTypesOrLabel('pain_bug_type', $item->getPreviousValue()) : __('Not determined');
                    $new_value = $item->getCurrentValue() ? \thebuggenie\core\entities\Issue::getPainTypesOrLabel('pain_bug_type', $item->getCurrentValue()) : __('Not determined');
                    echo __("Pain bug type on issue changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_PAIN_EFFECT:
                echo fa_image_tag('edit', ['class' => 'log_issue_pain_effect']);
                if ($item->hasChangeDetails()) {
                    $previous_value = $item->getPreviousValue() ? \thebuggenie\core\entities\Issue::getPainTypesOrLabel('pain_effect', $item->getPreviousValue()) : __('Not determined');
                    $new_value = $item->getCurrentValue() ? \thebuggenie\core\entities\Issue::getPainTypesOrLabel('pain_effect', $item->getCurrentValue()) : __('Not determined');
                    echo __("Pain effect on issue changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_PAIN_LIKELIHOOD:
                echo fa_image_tag('edit', ['class' => 'log_issue_pain_likelihood']);
                if ($item->hasChangeDetails()) {
                    $previous_value = $item->getPreviousValue() ? \thebuggenie\core\entities\Issue::getPainTypesOrLabel('pain_likelihood', $item->getPreviousValue()) : __('Not determined');
                    $new_value = $item->getCurrentValue() ? \thebuggenie\core\entities\Issue::getPainTypesOrLabel('pain_likelihood', $item->getCurrentValue()) : __('Not determined');
                    echo __("Likelihood on issue changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_PAIN_SCORE:
                echo fa_image_tag('exclamation-circle', ['class' => 'log_issue_pain_calculated']);
                if ($item->hasChangeDetails()) {
                    echo __("Calculated pain on issue changed: %value", ['%value' => '<strong>' . $item->getText() . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_USER_WORKING_ON_ISSUE:
                echo fa_image_tag('user', ['class' => 'log_issue_user_working']);
                if ($item->hasChangeDetails()) {
                    $previous_value = ($item->getPreviousValue()) ? (($old_item = \thebuggenie\core\entities\User::getB2DBTable()->selectById($item->getPreviousValue())) ? get_component_html('main/userdropdown_inline', ['user' => $old_item]) : '<strong>' . __('Unknown') . '</strong>') : '<strong>' . __('Not determined') . '</strong>';
                    $new_value = ($item->getCurrentValue()) ? (($new_item = \thebuggenie\core\entities\User::getB2DBTable()->selectById($item->getCurrentValue())) ? get_component_html('main/userdropdown_inline', ['user' => $new_item]) : '<strong>' . __('Unknown') . '</strong>') : '<strong>' . __('Not determined') . '</strong>';
                    echo __("User working on issue changed from %previous_value to %new_value", ['%previous_value' => $previous_value, '%new_value' => $new_value]);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_ASSIGNEE:
                echo fa_image_tag('user-plus', ['class' => 'log_issue_assignee']);
                echo __("Assignee changed to %new_value", ['%new_value' => '<strong>' . $item->getText() . '</strong>']);
                break;
            case LogItem::ACTION_ISSUE_UPDATE_TIME_SPENT:
                echo fa_image_tag('clock', ['class' => 'log_issue_time_spent']);
                echo __("Time spent changed: %value", ['%value' => '<strong>' . \thebuggenie\core\entities\common\Timeable::formatTimeableLog($item->getText(), $item->getPreviousValue(), $item->getCurrentValue(), true, true) . '</strong>']);
                break;
            case LogItem::ACTION_ISSUE_UPDATE_PERCENT_COMPLETE:
                echo fa_image_tag('percent', ['class' => 'log_issue_percent']);
                if ($item->hasChangeDetails()) {
                    echo __("Percent complete changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . (int)$item->getPreviousValue() . '</strong>', '%new_value' => '<strong>' . (int)$item->getCurrentValue() . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_ADD_BLOCKING:
                echo fa_image_tag('exclamation-triangle', ['class' => 'log_issue_blocked']);
                echo __('Blocking status changed: %value', ['%value' => '<strong>' . __('This issue is blocking the next release') . '</strong>']);
                break;
            case LogItem::ACTION_ISSUE_REMOVE_BLOCKING:
                echo fa_image_tag('exclamation-triangle', ['class' => 'log_issue_unblocked']);
                echo __('Blocking status changed: %value', ['%value' => '<strong>' . __('This issue is no more blocking the next release') . '</strong>']);
                break;
            case LogItem::ACTION_ISSUE_UPDATE_ESTIMATED_TIME:
                echo fa_image_tag('clock', ['class' => 'log_issue_time_estimated']);
                if ($item->hasChangeDetails()) {
                    echo __("Estimated time changed: %value", ['%value' => '<strong>' . \thebuggenie\core\entities\common\Timeable::formatTimeableLog($item->getText(), $item->getPreviousValue(), $item->getCurrentValue(), true, true) . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_ADD_AFFECTED_ITEM:
                echo fa_image_tag('cubes', ['class' => 'log_issue_affected_item_add']);
                if ($item->hasChangeDetails()) {
                    echo __("Affected item added: %value", ['%value' => '<strong>' . $item->getText() . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_AFFECTED_ITEM:
                echo fa_image_tag('cubes', ['class' => 'log_issue_affected_item_update']);
                if ($item->hasChangeDetails()) {
                    echo __("Affected item updated: %value", ['%value' => '<strong>' . $item->getText() . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_REMOVE_AFFECTED_ITEM:
                echo fa_image_tag('cubes', ['class' => 'log_issue_affected_item_delete']);
                if ($item->hasChangeDetails()) {
                    echo __("Affected time removed: %value", ['%value' => '<strong>' . $item->getText() . '</strong>']);
                }
                break;
            case LogItem::ACTION_ISSUE_UPDATE_REPRODUCTION_STEPS:
                echo fa_image_tag('list-ol', ['class' => 'log_issue_reproduction_steps']);
                if ($item->hasChangeDetails()) {
                    $previous_value = $item->getPreviousValue() ? $item->getPreviousValue() : __('Not determined');
                    $new_value = $item->getCurrentValue() ? $item->getCurrentValue() : __('Not determined');
                    echo __("Reproduction steps changed from %previous_value to %new_value", ['%previous_value' => '<strong>' . $previous_value . '</strong>', '%new_value' => '<strong>' . $new_value . '</strong>']);
                }
                break;
            default:
                echo $item->getChangeType();
        }
        if (!$item->hasChangeDetails()) {
            echo $item->getText();
        }
    } catch (\Exception $e) {
        echo __('Unknown change');
    }
}