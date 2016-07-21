<?php namespace LogExpander\Events;

class ScormSubmitted extends Event {
    /**
     * Reads data for an event.
     * @param [String => Mixed] $opts
     * @return [String => Mixed]
     * @override Event
     */
    public function read(array $opts) {
        $cmi_unserialized = unserialize($opts['other']);
        $scoid = $opts['contextinstanceid'];
        $scormid = $opts['objectid'];
        $attempt = $cmi_unserialized['attemptid'];
        $scorm_scoes_track = $this->repo->readScormScoesTrack($opts['userid'],
                                                              $scormid,
                                                              $scoid,
                                                              $attempt);
        return array_merge(parent::read($opts), [
            'module' => $this->repo->readModule($scormid, 'scorm'),
            'scorm_scoes_track' => $scorm_scoes_track,
            'scorm_scoes' => $this->repo->readModule($scoid, 'scorm_scoes'),
            'cmi_data' => $cmi_unserialized,
        ]);
    }
}
